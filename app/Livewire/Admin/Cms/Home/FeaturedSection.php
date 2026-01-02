<?php

namespace App\Livewire\Admin\Cms\Home;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Cms;
use App\Models\CmsMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FeaturedSection extends Component
{
    use WithFileUploads;

    // --- Images (Carousel) ---
    public $newFeaturedImages = [];
    public $existingFeaturedImages = [];

    // --- Book Details ---
    public $featuredCategory;
    public $featuredTitle;
    public $featuredPrice;
    public $featuredDiscountPrice;

    // --- Author ---
    public $featuredAuthorName;
    public $featuredAuthorAvatar;
    public $existingAuthorAvatar;

    // --- Rating (Float) ---
    public $featuredBookRating = 5.0;

    // --- Buttons ---
    public $featuredBtn1Text;
    public $featuredBtn1Link;
    public $featuredBtn2Text;
    public $featuredBtn2Link;

    // --- Right Side Content ---
    public $featuredRightHeading;
    public $featuredRightSummary;

    // --- System Identifiers ---
    private string $pageKey = 'home';
    private string $sectionKey = 'featured-book-section';

    protected $rules = [
        'newFeaturedImages.*'   => 'image|max:10240', // Check if images are > 2MB
        'featuredCategory'      => 'required|string|max:100',
        'featuredTitle'         => 'required|string|max:255',
        'featuredPrice'         => 'required|numeric',
        'featuredDiscountPrice' => 'nullable|numeric',
        'featuredAuthorName'    => 'required|string|max:100',
        'featuredAuthorAvatar'  => 'nullable|image|max:5120',
        'featuredBookRating'    => 'required|numeric|min:0|max:5',
        'featuredBtn1Text'      => 'required|string|max:50',
        'featuredBtn1Link'      => 'required|string|max:255',
        'featuredBtn2Text'      => 'nullable|string|max:50',
        'featuredBtn2Link'      => 'nullable|string|max:255',
        'featuredRightHeading'  => 'required|string|max:255',
        'featuredRightSummary'  => 'nullable|string',
    ];

    public function mount()
    {
        $cmsRecord = Cms::where('page', $this->pageKey)->where('type', $this->sectionKey)->first();

        if ($cmsRecord) {
            $data = CmsMeta::where('cms_id', $cmsRecord->id)->pluck('meta_value', 'meta_key')->toArray();

            $this->existingFeaturedImages = isset($data['featuredBookImages'])
                ? json_decode($data['featuredBookImages'], true) ?? []
                : [];

            $this->existingAuthorAvatar = $data['featuredAuthorAvatar'] ?? null;

            $this->featuredCategory       = $data['featuredCategory'] ?? '';
            $this->featuredTitle          = $data['featuredTitle'] ?? '';
            $this->featuredPrice          = $data['featuredPrice'] ?? '';
            $this->featuredDiscountPrice  = $data['featuredDiscountPrice'] ?? '';
            $this->featuredAuthorName     = $data['featuredAuthorName'] ?? '';
            $this->featuredBookRating     = floatval($data['featuredBookRating'] ?? 5.0);

            $this->featuredBtn1Text       = $data['featuredBtn1Text'] ?? '';
            $this->featuredBtn1Link       = $data['featuredBtn1Link'] ?? '';
            $this->featuredBtn2Text       = $data['featuredBtn2Text'] ?? '';
            $this->featuredBtn2Link       = $data['featuredBtn2Link'] ?? '';

            $this->featuredRightHeading   = $data['featuredRightHeading'] ?? '';
            $this->featuredRightSummary   = $data['featuredRightSummary'] ?? '';
        }
    }

    public function removeImage($index)
    {
        if (isset($this->existingFeaturedImages[$index])) {
            unset($this->existingFeaturedImages[$index]);
            $this->existingFeaturedImages = array_values($this->existingFeaturedImages);
        }
    }

    public function setRating($val)
    {
        $this->featuredBookRating = (float)$val;
    }

    public function saveFeaturedSection()
    {
        // 1. Validation Logic with Logging
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log the validation errors to storage/logs/laravel.log
            Log::error('CMS Validation Failed:', $e->errors());
            throw $e; // Re-throw so Livewire handles the UI errors
        }

        // 2. Handle Carousel Uploads
        $finalImagePaths = $this->existingFeaturedImages;
        if (!empty($this->newFeaturedImages)) {
            foreach ($this->newFeaturedImages as $img) {
                // Store returns the path, e.g., "cms/home/featured/abc.jpg"
                $path = $img->store('cms/home/featured', 'public');
                $finalImagePaths[] = $path;
            }
        }

        // 3. Handle Author Avatar
        $avatarPath = $this->existingAuthorAvatar;
        if ($this->featuredAuthorAvatar) {
             if ($this->existingAuthorAvatar && Storage::disk('public')->exists($this->existingAuthorAvatar)) {
                Storage::disk('public')->delete($this->existingAuthorAvatar);
            }
            $avatarPath = $this->featuredAuthorAvatar->store('cms/home/featured', 'public');
        }

        // 4. Prepare Data
        $inputData = [
            'featuredBookImages'    => json_encode($finalImagePaths),
            'featuredCategory'      => $this->featuredCategory,
            'featuredTitle'         => $this->featuredTitle,
            'featuredPrice'         => $this->featuredPrice,
            'featuredDiscountPrice' => $this->featuredDiscountPrice,
            'featuredAuthorName'    => $this->featuredAuthorName,
            'featuredAuthorAvatar'  => $avatarPath,
            'featuredBookRating'    => $this->featuredBookRating,
            'featuredBtn1Text'      => $this->featuredBtn1Text,
            'featuredBtn1Link'      => $this->featuredBtn1Link,
            'featuredBtn2Text'      => $this->featuredBtn2Text,
            'featuredBtn2Link'      => $this->featuredBtn2Link,
            'featuredRightHeading'  => $this->featuredRightHeading,
            'featuredRightSummary'  => $this->featuredRightSummary,
        ];

        // 5. Save to DB
        // Use updateOrCreate for the parent record too, just to be safe
        $cmsRecord = Cms::firstOrCreate(
            ['page' => $this->pageKey, 'type' => $this->sectionKey],
            ['created_at' => now(), 'updated_at' => now()]
        );

        DB::beginTransaction();
        try {
            foreach ($inputData as $key => $value) {
                // Ensure value is not null, but allow empty strings
                if (!is_null($value)) {
                    CmsMeta::updateOrCreate(
                        ['cms_id' => $cmsRecord->id, 'meta_key' => $key],
                        ['meta_value' => $value]
                    );
                }
            }
            DB::commit();

            // Reset Uploads
            $this->existingFeaturedImages = $finalImagePaths;
            $this->newFeaturedImages = [];
            $this->existingAuthorAvatar = $avatarPath;
            $this->featuredAuthorAvatar = null;

            $this->dispatch('settings-saved');
            session()->flash('message', 'Featured Book Section updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CMS Database Error: ' . $e->getMessage());
            session()->flash('error', 'Database error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'javascript:void(0)', 'name' => "Home"],
            ['link' => 'javascript:void(0)', 'name' => "Featured Book"],
        ];
        return view('livewire.admin.cms.home.featured-section', compact('breadcrumbs'));
    }
}
