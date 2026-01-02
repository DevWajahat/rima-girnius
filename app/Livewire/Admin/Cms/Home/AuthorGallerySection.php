<?php

namespace App\Livewire\Admin\Cms\Home;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Cms;
use App\Models\CmsMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthorGallerySection extends Component
{
    use WithFileUploads;

    // --- Properties ---
    public $galleryHeading = '';

    // 👇 THIS WAS CAUSING THE ERROR. IT MUST BE PUBLIC.
    public $existingGalleryImages = [];

    public $newGalleryImages = [];

    // --- System Identifiers ---
    private string $pageKey = 'home';
    private string $sectionKey = 'author-gallery-section';

    protected $rules = [
        'galleryHeading'      => 'required|string|max:255',
        'newGalleryImages.*'  => 'image|max:10240', // 10MB
        'existingGalleryImages' => 'array',
    ];

    public function mount()
    {
        $cmsRecord = Cms::where('page', $this->pageKey)->where('type', $this->sectionKey)->first();

        if ($cmsRecord) {
            $data = CmsMeta::where('cms_id', $cmsRecord->id)->pluck('meta_value', 'meta_key')->toArray();

            $this->galleryHeading = $data['galleryHeading'] ?? '';

            // Safety Check: Decode JSON
            $decoded = isset($data['galleryImages']) ? json_decode($data['galleryImages'], true) : [];
            $this->existingGalleryImages = is_array($decoded) ? $decoded : [];
        }
    }

    public function removeImage($index)
    {
        if (isset($this->existingGalleryImages[$index])) {
            unset($this->existingGalleryImages[$index]);
            $this->existingGalleryImages = array_values($this->existingGalleryImages);
        }
    }

    public function removeNewImage($index)
    {
        if (isset($this->newGalleryImages[$index])) {
            array_splice($this->newGalleryImages, $index, 1);
        }
    }

    public function saveGallerySection()
    {
        $this->validate();

        // 1. Merge Images
        $finalImagePaths = $this->existingGalleryImages;

        if (!empty($this->newGalleryImages)) {
            foreach ($this->newGalleryImages as $img) {
                $path = $img->store('cms/home/gallery', 'public');
                $finalImagePaths[] = $path;
            }
        }

        // 2. Prepare Data
        $inputData = [
            'galleryHeading' => $this->galleryHeading,
            'galleryImages'  => json_encode($finalImagePaths),
        ];

        // 3. Save to DB
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

            $this->existingGalleryImages = $finalImagePaths;
            $this->newGalleryImages = [];

            $this->dispatch('settings-saved');
            session()->flash('message', 'Gallery Section updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gallery Save Error: ' . $e->getMessage());
            session()->flash('error', 'Database error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'javascript:void(0)', 'name' => "Home"],
            ['link' => 'javascript:void(0)', 'name' => "Author Gallery"],
        ];
        return view('livewire.admin.cms.home.author-gallery-section', compact('breadcrumbs'));
    }
}
