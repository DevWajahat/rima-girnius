<?php

namespace App\Livewire\Admin\Cms\About;

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
    // Renamed to match meta keys strictly
    public $authorHeading;
    public $galleryImages = []; // Array of paths (previously existingImages)

    public $newImages = [];      // Array of temporary uploaded files

    // --- System Identifiers ---
    private string $pageKey = 'about';
    private string $sectionKey = 'author-gallery';

    protected $rules = [
        'authorHeading' => 'required|string|max:255',
        'newImages.*'   => 'image|max:10240', // 10MB max per image
    ];

    public function mount()
    {
        // 1. Fetch Existing Data
        $cmsRecord = Cms::where('page', $this->pageKey)->where('type', $this->sectionKey)->first();

        if ($cmsRecord) {
            $data = CmsMeta::where('cms_id', $cmsRecord->id)->pluck('meta_value', 'meta_key')->toArray();

            // Mapping DB keys strictly
            $this->authorHeading = $data['authorHeading'] ?? 'Author Gallery';

            // Decode the JSON string using the key 'galleryImages'
            if (isset($data['galleryImages'])) {
                $this->galleryImages = json_decode($data['galleryImages'], true) ?? [];
            }
        }
    }

    // Remove an image from the "Existing" list
    public function removeImage($index)
    {
        unset($this->galleryImages[$index]);
        $this->galleryImages = array_values($this->galleryImages); // Re-index array
    }

    // Clear the "New Uploads" buffer
    public function removeNewImage($index)
    {
        unset($this->newImages[$index]);
        $this->newImages = array_values($this->newImages);
    }

    public function save()
    {
        $this->validate();

        try {
            // 1. Process New Images
            foreach ($this->newImages as $image) {
                // Store and add path to galleryImages list
                $path = $image->store('cms/about/gallery', 'public');
                $this->galleryImages[] = $path;
            }

            // 2. Prepare Data for DB (Using strictly requested keys)
            $inputData = [
                'authorHeading' => $this->authorHeading,
                'galleryImages' => json_encode($this->galleryImages),
            ];

            // 3. Save to DB
            $cmsRecord = Cms::firstOrCreate(
                ['page' => $this->pageKey, 'type' => $this->sectionKey],
                ['created_at' => now(), 'updated_at' => now()]
            );

            DB::beginTransaction();
            foreach ($inputData as $key => $value) {
                if (!is_null($value)) {
                    CmsMeta::updateOrCreate(
                        ['cms_id' => $cmsRecord->id, 'meta_key' => $key],
                        ['meta_value' => $value]
                    );
                }
            }
            DB::commit();

            // 4. Reset UI
            $this->newImages = []; // Clear upload buffer
            $this->dispatch('settings-saved');
            session()->flash('message', 'Gallery updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gallery Save Error: ' . $e->getMessage());
            session()->flash('error', 'Database error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'javascript:void(0)', 'name' => "About Page"],
            ['link' => 'javascript:void(0)', 'name' => "Author Gallery"],
        ];
        return view('livewire.admin.cms.about.author-gallery-section', compact('breadcrumbs'));
    }
}
