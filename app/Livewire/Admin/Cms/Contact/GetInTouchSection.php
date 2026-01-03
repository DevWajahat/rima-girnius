<?php

namespace App\Livewire\Admin\Cms\Contact;

use Livewire\Component;
use App\Models\Cms;
use App\Models\CmsMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetInTouchSection extends Component
{
    // --- Properties ---
    // 1. Top Section
    public $mainHeading;
    public $mainSubHeading;

    // 2. Left Column Content
    public $contentHeading;
    public $contentDescription; // Froala or Textarea
    public $email;
    public $location;

    // 3. Social Media
    public $socialInstagram;
    public $socialX; // Twitter/X
    public $socialFacebook;

    // --- System Identifiers ---
    private string $pageKey = 'contact';
    private string $sectionKey = 'get-in-touch';

    protected $rules = [
        'mainHeading'        => 'required|string|max:255',
        'mainSubHeading'     => 'nullable|string|max:500',
        'contentHeading'     => 'required|string|max:255',
        'contentDescription' => 'nullable|string',
        'email'              => 'nullable|email',
        'location'           => 'nullable|string|max:255',
        'socialInstagram'    => 'nullable|url',
        'socialX'            => 'nullable|url',
        'socialFacebook'     => 'nullable|url',
    ];

    public function mount()
    {
        // 1. Fetch Existing Data
        $cmsRecord = Cms::where('page', $this->pageKey)->where('type', $this->sectionKey)->first();

        if ($cmsRecord) {
            $data = CmsMeta::where('cms_id', $cmsRecord->id)->pluck('meta_value', 'meta_key')->toArray();

            $this->mainHeading        = $data['mainHeading'] ?? 'Contact';
            $this->mainSubHeading     = $data['mainSubHeading'] ?? '';
            $this->contentHeading     = $data['contentHeading'] ?? 'Get in Touch';
            $this->contentDescription = $data['contentDescription'] ?? '';
            $this->email              = $data['email'] ?? '';
            $this->location           = $data['location'] ?? '';
            $this->socialInstagram    = $data['socialInstagram'] ?? '';
            $this->socialX            = $data['socialX'] ?? '';
            $this->socialFacebook     = $data['socialFacebook'] ?? '';
        }
    }

    public function save()
    {
        $this->validate();

        // 2. Prepare Data
        $inputData = [
            'mainHeading'        => $this->mainHeading,
            'mainSubHeading'     => $this->mainSubHeading,
            'contentHeading'     => $this->contentHeading,
            'contentDescription' => $this->contentDescription,
            'email'              => $this->email,
            'location'           => $this->location,
            'socialInstagram'    => $this->socialInstagram,
            'socialX'            => $this->socialX,
            'socialFacebook'     => $this->socialFacebook,
        ];

        // 3. Save to DB
        $cmsRecord = Cms::firstOrCreate(
            ['page' => $this->pageKey, 'type' => $this->sectionKey],
            ['created_at' => now(), 'updated_at' => now()]
        );

        DB::beginTransaction();
        try {
            foreach ($inputData as $key => $value) {
                // We save even empty strings to allow clearing values
                CmsMeta::updateOrCreate(
                    ['cms_id' => $cmsRecord->id, 'meta_key' => $key],
                    ['meta_value' => $value ?? '']
                );
            }
            DB::commit();

            $this->dispatch('settings-saved');
            session()->flash('message', 'Contact section updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Contact CMS Error: ' . $e->getMessage());
            session()->flash('error', 'Database error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'javascript:void(0)', 'name' => "Contact Page"],
            ['link' => 'javascript:void(0)', 'name' => "Get In Touch"],
        ];
        return view('livewire.admin.cms.contact.get-in-touch-section', compact('breadcrumbs'));
    }
}
