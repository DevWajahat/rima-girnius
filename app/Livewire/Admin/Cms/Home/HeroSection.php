<?php

namespace App\Livewire\Admin\Cms\Home;

use Livewire\Component;
use Livewire\WithFileUploads; // Required for image uploads
use App\Models\Cms;
use App\Models\CmsMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HeroSection extends Component
{
    use WithFileUploads;

    // Form Properties
    public $heroBookImage; // The temporary uploaded file
    public $existingHeroBookImage; // The path to the currently saved image

    public $heroCategory;
    public $heroTitle;
    public $heroDescription;
    public $heroButtonText;
    public $heroButtonLink;

    // Identifiers
    private string $pageKey = 'home';
    private string $sectionKey = 'hero-section';

    protected $rules = [
        'heroBookImage'   => 'nullable|image|max:2048|mimes:jpeg,jpg,png,webp', // Max 2MB
        'heroCategory'    => 'required|string|max:100',
        'heroTitle'       => 'required|string|max:255',
        'heroDescription' => 'required|string',
        'heroButtonText'  => 'required|string|max:50',
        'heroButtonLink'  => 'required|string|max:255',
    ];

    public function mount()
    {
        $cmsRecord = Cms::where('page', $this->pageKey)->where('type', $this->sectionKey)->first();

        if ($cmsRecord) {
            $data = CmsMeta::where('cms_id', $cmsRecord->id)->pluck('meta_value', 'meta_key')->toArray();

            $this->existingHeroBookImage = $data['heroBookImage'] ?? null;
            $this->heroCategory     = $data['heroCategory'] ?? '';
            $this->heroTitle        = $data['heroTitle'] ?? '';
            $this->heroDescription  = $data['heroDescription'] ?? '';
            $this->heroButtonText   = $data['heroButtonText'] ?? '';
            $this->heroButtonLink   = $data['heroButtonLink'] ?? '';
        }
    }

    public function save()
    {
        $this->validate();

        // 1. Handle Image Upload
        $imagePath = $this->existingHeroBookImage;

        if ($this->heroBookImage) {
            // Delete old image if it exists and isn't a default placeholder
            if ($this->existingHeroBookImage && Storage::disk('public')->exists($this->existingHeroBookImage)) {
                Storage::disk('public')->delete($this->existingHeroBookImage);
            }
            // Store new image in 'cms/home' folder on the 'public' disk
            $imagePath = $this->heroBookImage->store('cms/home', 'public');
        }

        // 2. Prepare Data
        $inputData = [
            'heroBookImage'   => $imagePath,
            'heroCategory'    => $this->heroCategory,
            'heroTitle'       => $this->heroTitle,
            'heroDescription' => $this->heroDescription,
            'heroButtonText'  => $this->heroButtonText,
            'heroButtonLink'  => $this->heroButtonLink,
        ];

        // 3. Find/Create Parent Record
        // We use firstOrCreate to ensure the parent row exists if the table was truncated
        $cmsRecord = Cms::firstOrCreate(
            ['page' => $this->pageKey, 'type' => $this->sectionKey],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // 4. Save Meta Data Transactionally
        DB::beginTransaction();
        try {
            foreach ($inputData as $key => $value) {
                if ($value !== null) { // Only save if not null
                    CmsMeta::updateOrCreate(
                        ['cms_id' => $cmsRecord->id, 'meta_key' => $key],
                        ['meta_value' => $value]
                    );
                }
            }
            DB::commit();

            // Update local state for the image (so the preview updates immediately without refresh)
            $this->existingHeroBookImage = $imagePath;
            $this->heroBookImage = null; // Reset file input

            session()->flash('message', 'Hero Section updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Database error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'javascript:void(0)', 'name' => "Home"],
            ['link' => 'javascript:void(0)', 'name' => "Hero Section"],
        ];
        return view('livewire.admin.cms.home.hero-section', compact('breadcrumbs'));
    }
}
