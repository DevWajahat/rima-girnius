<?php

namespace App\Livewire\Admin\Cms\Home;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Cms;
use App\Models\CmsMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AboutSection extends Component
{
    use WithFileUploads;

    // --- Properties ---
    public $aboutHeading;
    public $aboutImage;         // For new upload
    public $existingAboutImage; // For stored path
    public $aboutDescription;   // Froala Content

    // --- System Identifiers ---
    private string $pageKey = 'home';
    private string $sectionKey = 'about-section';

    protected $rules = [
        'aboutHeading'     => 'required|string|max:255',
        // Increased max size to 5MB (5120KB) to prevent validation errors
        'aboutImage'       => 'nullable|image|max:5120',
        'aboutDescription' => 'nullable|string',
    ];

    public function mount()
    {
        // 1. Fetch Existing Data
        $cmsRecord = Cms::where('page', $this->pageKey)->where('type', $this->sectionKey)->first();

        if ($cmsRecord) {
            $data = CmsMeta::where('cms_id', $cmsRecord->id)->pluck('meta_value', 'meta_key')->toArray();

            $this->aboutHeading       = $data['aboutHeading'] ?? '';
            $this->existingAboutImage = $data['aboutImage'] ?? null;
            $this->aboutDescription   = $data['aboutDescription'] ?? '';
        }
    }

    public function saveAboutSection()
    {
        // 1. Validation
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('About Section Validation Failed:', $e->errors());
            throw $e;
        }

        // 2. Handle Image Upload
        $finalImagePath = $this->existingAboutImage;

        if ($this->aboutImage) {
            // Delete old image if exists
            if ($this->existingAboutImage && Storage::disk('public')->exists($this->existingAboutImage)) {
                Storage::disk('public')->delete($this->existingAboutImage);
            }
            // Store new image
            $finalImagePath = $this->aboutImage->store('cms/home/about', 'public');
        }

        // 3. Prepare Data
        $inputData = [
            'aboutHeading'     => $this->aboutHeading,
            'aboutImage'       => $finalImagePath,
            'aboutDescription' => $this->aboutDescription,
        ];

        // 4. Save to DB
        $cmsRecord = Cms::firstOrCreate(
            ['page' => $this->pageKey, 'type' => $this->sectionKey],
            ['created_at' => now(), 'updated_at' => now()]
        );

        DB::beginTransaction();
        try {
            foreach ($inputData as $key => $value) {
                if (!is_null($value)) {
                    CmsMeta::updateOrCreate(
                        ['cms_id' => $cmsRecord->id, 'meta_key' => $key],
                        ['meta_value' => $value]
                    );
                }
            }
            DB::commit();

            // Reset Upload Property but keep the path for preview
            $this->existingAboutImage = $finalImagePath;
            $this->aboutImage = null;

            $this->dispatch('settings-saved');
            session()->flash('message', 'About Section updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('About Section DB Error: ' . $e->getMessage());
            session()->flash('error', 'Database error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'javascript:void(0)', 'name' => "Home"],
            ['link' => 'javascript:void(0)', 'name' => "About Author"],
        ];
        return view('livewire.admin.cms.home.about-section', compact('breadcrumbs'));
    }
}
