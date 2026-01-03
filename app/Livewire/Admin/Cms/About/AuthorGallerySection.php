<?php

namespace App\Livewire\Admin\Cms\About;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Cms;
use App\Models\CmsMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AuthorGallerySection extends Component
{
    use WithFileUploads;

    // --- Properties ---
    public $heading;
    public $existingImages = []; // Array of paths from DB
    public $newImages = [];      // Array of temporary uploaded files

    // --- System Identifiers ---
    private string $pageKey = 'about';
    private string $sectionKey = 'author-gallery';

    protected $rules = [
        'heading'      => 'required|string|max:255',
        'newImages.*'  => 'image|max:10240', // 10MB max per image
    ];

    public function mount()
    {
        // 1. Fetch Existing Data
        $cmsRecord = Cms::where('page', $this->pageKey)->where('type', $this->sectionKey)->first();

        if ($cmsRecord) {
            $data = CmsMeta::where('cms_id', $cmsRecord->id)->pluck('meta_value', 'meta_key')->toArray();

            $this->heading = $data['heading'] ?? 'Author Gallery';

            // Decode the JSON string back into an array for the view
            if (isset($data['gallery_images'])) {
                $this->existingImages = json_decode($data['gallery_images'], true) ?? [];
            }
        }
    }

    // Remove an image from the "Existing" list (Immediate UI update)
    public function removeImage($index)
    {
        // Optional: You could delete the file from storage here immediately,
        // or just remove it from the list and let the file stay (orphaned) until a cleanup script runs.
        // For CMS safety, we just remove it from the active list for now.
        unset($this->existingImages[$index]);
        $this->existingImages = array_values($this->existingImages); // Re-index array
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
                // Store and add path to existing list
                $path = $image->store('cms/about/gallery', 'public');
                $this->existingImages[] = $path;
            }

            // 2. Prepare Data for DB
            // We store the array of paths as a JSON string
            $inputData = [
                'heading'        => $this->heading,
                'gallery_images' => json_encode($this->existingImages),
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
