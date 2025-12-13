<?php

namespace App\Livewire\Admin\Cms\Home;

use Livewire\Component;
use App\Models\Cms;
use App\Models\CmsMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;


class FeaturedSection extends Component
{
    use WithFileUploads;

    // Properties for the form fields
    public $bookTitle;
    public $bookDescription;
    public $bookImage; // For new file upload
    public $existingBookImage; // To display existing image path

    // Fixed identifiers for this section
    private string $pageKey = 'home';
    private string $sectionKey = 'featured-book-section';

    // Base Validation rules: Image is always optional in this static list
    protected $rules = [
        'bookTitle'       => 'required|string|max:255',
        'bookDescription' => 'required|string',
        'bookImage'       => 'nullable|image|max:2048', // Base rule is nullable
    ];

    /**
     * Retrieves the Cms model instance for this section.
     */
    private function getCmsRecord()
    {
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
            $metaData = CmsMeta::where('cms_id', $cmsRecord->id)->get();
            $data = $metaData->pluck('meta_value', 'meta_key')->toArray();
        }

        // Populate properties from the associative array
        $this->bookTitle           = $data['bookTitle'] ?? '';
        $this->bookDescription     = $data['bookDescription'] ?? '';
        $this->existingBookImage   = $data['bookImage'] ?? '';
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Handle form submission and save data by updating/creating rows in cms_metas.
     */
    public function saveFeaturedBookSection()
    {
        // 1. Define a dynamic set of rules based on existing image status
        $dynamicRules = $this->rules;

        // If no existing image is present, make the upload required
        if (empty($this->existingBookImage)) {
            $dynamicRules['bookImage'] = 'required|image|max:2048';
        }

        // 2. Validate using the dynamic rules
        $this->validate($dynamicRules);

        $cmsRecord = $this->getCmsRecord();

        if (!$cmsRecord) {
            session()->flash('error', 'Error: The parent CMS record (' . $this->pageKey . ' / ' . $this->sectionKey . ') was not found.');
            return;
        }

        $cmsId = $cmsRecord->id;
        $inputData = [
            'bookTitle'       => $this->bookTitle,
            'bookDescription' => $this->bookDescription,
        ];

        // Handle Image Upload
        if ($this->bookImage) {
            // Define the new storage path
            $storagePath = 'uploads/images/featured-book-section'; // <-- NEW PATH

            // Delete old image if it exists
            if ($this->existingBookImage && Storage::disk('public')->exists($this->existingBookImage)) {
                Storage::disk('public')->delete($this->existingBookImage);
            }

            // Store the new image in the specified folder under the 'public' disk
            // This will save the image to public/storage/uploads/images/featured-book-section
            $imagePath = $this->bookImage->store($storagePath, 'public');
            $inputData['bookImage'] = $imagePath;
        } else {
            // Keep existing image if no new file is uploaded
            $inputData['bookImage'] = $this->existingBookImage;
        }

        // Start transaction for atomic updates
        DB::beginTransaction();
        try {
            foreach ($inputData as $meta_key => $meta_value) {
                // Find existing meta-row or create a new one
                CmsMeta::updateOrCreate(
                    [
                        'cms_id'   => $cmsId,
                        'meta_key' => $meta_key,
                    ],
                    [
                        'meta_value' => $meta_value,
                    ]
                );
            }
            DB::commit();

            // Update the existing image path property after successful save
            $this->existingBookImage = $inputData['bookImage'];

            session()->flash('message', 'Featured Book Section settings successfully saved.');
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
            ['link' => 'javascript:void(0)', 'name' => "Home Featured Book Section"],
        ];

        return view('livewire.admin.cms.home.featured-section', compact('breadcrumbs'));
    }
}
