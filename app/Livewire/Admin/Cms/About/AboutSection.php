<?php

namespace App\Livewire\Admin\Cms\About;

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
    public $heading;
    public $image;          // For new upload
    public $existingImage;  // For stored path
    public $description;    // Froala Content

    // --- System Identifiers ---
    private string $pageKey = 'about';
    private string $sectionKey = 'about-section';

    protected $rules = [
        'heading'     => 'required|string|max:255',
        'image'       => 'nullable|image|max:5120', // Max 5MB
        'description' => 'nullable|string',
    ];

    public function mount()
    {
        // 1. Fetch Existing Data
        $cmsRecord = Cms::where('page', $this->pageKey)->where('type', $this->sectionKey)->first();

        if ($cmsRecord) {
            $data = CmsMeta::where('cms_id', $cmsRecord->id)->pluck('meta_value', 'meta_key')->toArray();

            $this->heading       = $data['heading'] ?? '';
            $this->existingImage = $data['image'] ?? null;
            $this->description   = $data['description'] ?? '';
        }
    }

    public function save()
    {
        // 1. Validation
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validation-failed'); // Optional: for UI shake effects
            throw $e;
        }

        // 2. Handle Image Upload
        $finalImagePath = $this->existingImage;

        if ($this->image) {
            // Delete old image if exists
            if ($this->existingImage && Storage::disk('public')->exists($this->existingImage)) {
                Storage::disk('public')->delete($this->existingImage);
            }
            // Store new image
            $finalImagePath = $this->image->store('cms/about/author', 'public');
        }

        // 3. Prepare Data
        $inputData = [
            'heading'     => $this->heading,
            'image'       => $finalImagePath,
            'description' => $this->description,
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
            $this->existingImage = $finalImagePath;
            $this->image = null;

            $this->dispatch('settings-saved');
            session()->flash('message', 'About Page details updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('About Page CMS Error: ' . $e->getMessage());
            session()->flash('error', 'Database error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'javascript:void(0)', 'name' => "About Page"],
            ['link' => 'javascript:void(0)', 'name' => "About Section"],
        ];
        return view('livewire.admin.cms.about.about-section', compact('breadcrumbs'));
    }
}
