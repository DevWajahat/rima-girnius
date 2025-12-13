<?php

namespace App\Livewire\Admin\Cms\Home;

use App\Models\Cms;
use App\Models\CmsMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AboutSection extends Component
{
    use WithFileUploads;

    // Properties
    // We strictly define strings where possible to prevent hydration issues
    public string $sectionHeading = '';

    // We keep this untyped to gracefully handle potential array hydration,
    // but we treat it as a string everywhere in logic.
    public $authorBrief = '';

    public $authorImage;
    public string $existingAuthorImage = '';

    private string $pageKey = 'home';
    private string $sectionKey = 'about-section';

    protected $rules = [
        'sectionHeading'    => 'required|string|max:255',
        'authorBrief'       => 'required|string|max:10000',
        'authorImage'       => 'nullable|image|max:2048',
    ];

    private function getCmsRecord()
    {
        return Cms::where('page', $this->pageKey)
                   ->where('type', $this->sectionKey)
                   ->first();
    }

    public function mount()
    {
        $cmsRecord = $this->getCmsRecord();
        $data = [];

        if ($cmsRecord) {
            $metaData = CmsMeta::where('cms_id', $cmsRecord->id)->get();
            $data = $metaData->pluck('meta_value', 'meta_key')->toArray();
        }

        $this->sectionHeading      = (string) ($data['sectionHeading'] ?? 'About The Author');
        // Ensure initial load is string
        $this->authorBrief         = (string) ($data['authorBrief'] ?? '');
        $this->existingAuthorImage = (string) ($data['authorImage'] ?? '');
        $this->authorImage         = null;
    }

    // Intercept updates to force string type if array comes in from hydration
    public function updatedAuthorBrief($value)
    {
        if (is_array($value)) {
            $this->authorBrief = json_encode($value);
        }
    }

    /**
     * Save method now accepts content directly from the frontend JS.
     * This allows for a single "Atomic" request, fixing race conditions.
     */
    public function saveAboutSection($contentFromFrontend = null)
    {
        // 1. If frontend passed content directly via the save call, use it.
        // This guarantees we have the latest editor state.
        if ($contentFromFrontend !== null) {
            $this->authorBrief = $contentFromFrontend;
        }

        // 2. Sanity Check: Before validation, ensure it's a string.
        if (is_array($this->authorBrief)) {
            $this->authorBrief = empty($this->authorBrief) ? '' : json_encode($this->authorBrief);
        }

        $dynamicRules = $this->rules;

        if (empty($this->existingAuthorImage)) {
            $dynamicRules['authorImage'] = 'required|image|max:2048';
        }

        $this->validate($dynamicRules);

        $cmsRecord = $this->getCmsRecord();

        if (!$cmsRecord) {
            session()->flash('error', 'Error: Parent CMS record not found.');
            return;
        }

        $cmsId = $cmsRecord->id;

        $inputData = [
            'sectionHeading'    => $this->sectionHeading,
            'authorBrief'       => $this->authorBrief,
        ];

        // Handle Image Upload
        if ($this->authorImage) {
            $storagePath = 'uploads/images/home-about-section';

            if ($this->existingAuthorImage && Storage::disk('public')->exists($this->existingAuthorImage)) {
                Storage::disk('public')->delete($this->existingAuthorImage);
            }

            $imagePath = $this->authorImage->store($storagePath, 'public');
            $inputData['authorImage'] = $imagePath;
        } else {
            $inputData['authorImage'] = $this->existingAuthorImage;
        }

        // Database Transaction
        DB::beginTransaction();
        try {
            foreach ($inputData as $meta_key => $meta_value) {
                CmsMeta::updateOrCreate(
                    ['cms_id' => $cmsId, 'meta_key' => $meta_key],
                    ['meta_value' => (string) $meta_value] // Explicit cast for safety
                );
            }
            DB::commit();

            $this->existingAuthorImage = $inputData['authorImage'];

            session()->flash('message', 'About Section settings successfully saved.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Database error: ' . $e->getMessage());
        }

        $this->dispatch('settings-saved');
    }

    public function render()
    {
        // SOLUTION: Create a SEPARATE variable for the view.
        // We force-cast to string here. Even if $this->authorBrief is an array,
        // $safeContent will be a string, preventing the htmlspecialchars crash.

        $safeContent = is_array($this->authorBrief) ? json_encode($this->authorBrief) : (string) $this->authorBrief;

        return view('livewire.admin.cms.home.about-section', [
            'initialContent' => $safeContent
        ]);
    }
}
