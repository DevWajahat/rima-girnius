<?php

namespace App\Livewire\Admin\Cms\Home;

use Livewire\Component;
use App\Models\Cms;       // Assuming the main table model (page, type)
use App\Models\CmsMeta;  // Assuming the meta table model (cms_id, meta_key, meta_value)
use Illuminate\Support\Facades\DB;

class HeroSection extends Component
{
    // Properties for the form fields
    public $heroTitle;
    public $heroSubtitle;
    public $heroButtonText;
    public $heroButtonLink;

    // Fixed identifiers for this section
    private string $pageKey = 'home';
    private string $sectionKey = 'hero-section';

    // Validation rules
    protected $rules = [
        'heroTitle'      => 'required|string|max:255',
        'heroSubtitle'   => 'required|string|max:255',
        'heroButtonText' => 'required|string|max:100',
        'heroButtonLink' => 'required|string|max:255',
    ];

    /**
     * Retrieves the Cms model instance for this section.
     */
    private function getCmsRecord()
    {
        // 1. Find the parent CMS record (id=1, page=home, type=hero-section)
        return Cms::where('page', $this->pageKey)
                   ->where('type', $this->sectionKey)
                   ->first();
    }

    /**
     * Mount the component and retrieve existing meta-data.
     */
    public function mount()
    {
        $cmsRecord = $this->getCmsRecord();
        $data = [];

        if ($cmsRecord) {
            // 2. Load all meta-data associated with this CMS record and convert to an associative array
            // This relies on a relationship (e.g., $cmsRecord->metas) or a direct query.
            $metaData = CmsMeta::where('cms_id', $cmsRecord->id)->get();
            $data = $metaData->pluck('meta_value', 'meta_key')->toArray();
        }

        // 3. Populate properties from the associative array
        $this->heroTitle      = $data['heroTitle'] ?? '';
        $this->heroSubtitle   = $data['heroSubtitle'] ?? '';
        $this->heroButtonText = $data['heroButtonText'] ?? '';
        $this->heroButtonLink = $data['heroButtonLink'] ?? '';
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Handle form submission and save data by updating/creating rows in cms_metas.
     */
    public function saveHeroSection()
    {
        $this->validate();

        $inputData = [
            'heroTitle'      => $this->heroTitle,
            'heroSubtitle'   => $this->heroSubtitle,
            'heroButtonText' => $this->heroButtonText,
            'heroButtonLink' => $this->heroButtonLink,
        ];

        $cmsRecord = $this->getCmsRecord();

        if (!$cmsRecord) {
            session()->flash('error', 'Error: The parent CMS record (home / hero-section) was not found.');
            return;
        }

        $cmsId = $cmsRecord->id;

        // Start transaction for atomic updates
        DB::beginTransaction();
        try {
            foreach ($inputData as $meta_key => $meta_value) {
                // Find existing meta-row or create a new one
                CmsMeta::updateOrCreate(
                    [
                        'cms_id' => $cmsId,
                        'meta_key' => $meta_key,
                    ],
                    [
                        'meta_value' => $meta_value,
                    ]
                );
            }
            DB::commit();
            session()->flash('message', 'Hero Section settings successfully saved.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Database error during save: ' . $e->getMessage());
        }

        $this->dispatch('settings-saved');
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'javascript:void(0)', 'name' => "Pages"],
            ['link' => 'javascript:void(0)', 'name' => "Home Hero Section"],
        ];

        return view('livewire.admin.cms.home.hero-section', compact('breadcrumbs'));
    }
}
