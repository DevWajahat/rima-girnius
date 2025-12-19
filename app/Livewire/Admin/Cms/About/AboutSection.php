<?php

namespace App\Livewire\Admin\Cms\About;

use App\Models\Cms;
use App\Models\CmsMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AboutSection extends Component
{
    use WithFileUploads;

    public $iteration = 1;

    public string $sectionHeading = '';
    public $aboutDescription = '';
    public $aboutImage;
    public string $existingAboutImage = '';

    // --- NEW: Grid Cards Array ---
    public $grid_cards = [];

    private string $pageKey = 'about';
    private string $sectionKey = 'about-section';

    protected $rules = [
        'sectionHeading'        => 'required|string|max:255',
        'aboutDescription'      => 'required|string|max:10000',
        'aboutImage'            => 'nullable|image|max:2048',
        // Validate the array fields
        'grid_cards'            => 'array',
        'grid_cards.*.title'    => 'required|string|max:100',
        'grid_cards.*.desc'     => 'required|string|max:255',
        'grid_cards.*.icon'     => 'required|string|max:50',
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

        $this->sectionHeading     = (string) ($data['sectionHeading'] ?? 'About Us');
        $this->aboutDescription   = (string) ($data['aboutDescription'] ?? '');
        $this->existingAboutImage = (string) ($data['aboutImage'] ?? '');

        // --- NEW: Load Grid Cards from JSON ---
        $jsonCards = $data['grid_cards'] ?? '[]';
        $this->grid_cards = json_decode($jsonCards, true);

        // Ensure it is always an array
        if (!is_array($this->grid_cards)) {
            $this->grid_cards = [];
        }
    }

    // --- NEW: Add/Remove Actions ---
    public function addCard()
    {
        $this->grid_cards[] = [
            'title' => '',
            'desc'  => '',
            'icon'  => 'ri-star-line' // Default icon
        ];
    }

    public function removeCard($index)
    {
        unset($this->grid_cards[$index]);
        $this->grid_cards = array_values($this->grid_cards); // Re-index array
    }

    public function saveAboutSection($contentFromFrontend = null)
    {
        // 1. Sync Editor Content
        if ($contentFromFrontend !== null) {
            $this->aboutDescription = $contentFromFrontend;
        }

        // 2. Validation
        $dynamicRules = $this->rules;
        if (empty($this->existingAboutImage)) {
            $dynamicRules['aboutImage'] = 'required|image|max:2048';
        }
        $this->validate($dynamicRules);

        $cmsRecord = $this->getCmsRecord();
        if (!$cmsRecord) {
            session()->flash('error', 'Error: Parent CMS record not found.');
            return;
        }

        // 3. Prepare Data
        $inputData = [
            'sectionHeading'   => $this->sectionHeading,
            'aboutDescription' => $this->aboutDescription,
            // Encode array to JSON for storage
            'grid_cards'       => json_encode($this->grid_cards),
        ];

        // 4. Handle Image
        if ($this->aboutImage) {
            $storagePath = 'uploads/images/about-page/about-section';
            if ($this->existingAboutImage && Storage::disk('public')->exists($this->existingAboutImage)) {
                Storage::disk('public')->delete($this->existingAboutImage);
            }
            $imagePath = $this->aboutImage->store($storagePath, 'public');
            $inputData['aboutImage'] = $imagePath;
        } else {
            $inputData['aboutImage'] = $this->existingAboutImage;
        }

        // 5. Save to DB
        DB::beginTransaction();
        try {
            foreach ($inputData as $meta_key => $meta_value) {
                CmsMeta::updateOrCreate(
                    ['cms_id' => $cmsRecord->id, 'meta_key' => $meta_key],
                    ['meta_value' => (string) $meta_value]
                );
            }
            DB::commit();

            $this->existingAboutImage = $inputData['aboutImage'];
            $this->aboutImage = null;
            $this->iteration++;

            session()->flash('message', 'About Section saved successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Database error: ' . $e->getMessage());
        }

        $this->dispatch('settings-saved');
    }

    // Safety method
    public function toJSON() { return []; }

    public function render()
    {
        return view('livewire.admin.cms.about.about-section', [
            'initialContent' => $this->aboutDescription
        ]);
    }
}
