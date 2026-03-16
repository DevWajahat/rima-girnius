<?php

namespace App\Livewire\Admin\Cms\Home;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Cms;
use App\Models\CmsMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SocialPosterSection extends Component
{
    use WithFileUploads;

    public $posterHeading = '';
    public $existingPosters = [];
    public $newPosters = [];

    private string $pageKey = 'home';
    private string $sectionKey = 'social-poster-section';

    protected $rules = [
        'posterHeading'  => 'required|string|max:255',
        'newPosters.*'   => 'image|max:10240',
        'existingPosters' => 'array',
    ];

    public function mount()
    {
        $cmsRecord = Cms::where('page', $this->pageKey)->where('type', $this->sectionKey)->first();

        if ($cmsRecord) {
            $data = CmsMeta::where('cms_id', $cmsRecord->id)->pluck('meta_value', 'meta_key')->toArray();
            $this->posterHeading = $data['posterHeading'] ?? '';
            $decoded = isset($data['posterImages']) ? json_decode($data['posterImages'], true) : [];
            $this->existingPosters = is_array($decoded) ? $decoded : [];
        }
    }

    public function removeImage($index)
    {
        if (isset($this->existingPosters[$index])) {
            unset($this->existingPosters[$index]);
            $this->existingPosters = array_values($this->existingPosters);
        }
    }

    public function removeNewImage($index)
    {
        if (isset($this->newPosters[$index])) {
            array_splice($this->newPosters, $index, 1);
        }
    }

    public function updateOrder($orderedPaths)
    {
        $this->existingPosters = $orderedPaths;
    }

    public function saveSection()
    {
        $this->validate();

        $finalImagePaths = $this->existingPosters;

        if (!empty($this->newPosters)) {
            foreach ($this->newPosters as $img) {
                $path = $img->store('cms/home/social_posters', 'public');
                $finalImagePaths[] = $path;
            }
        }

        $inputData = [
            'posterHeading' => $this->posterHeading,
            'posterImages'  => json_encode($finalImagePaths),
        ];

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

            $this->existingPosters = $finalImagePaths;
            $this->newPosters = [];

            $this->dispatch('settings-saved');
            session()->flash('message', 'Social Posters updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Social Poster Save Error: ' . $e->getMessage());
            session()->flash('error', 'Database error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $breadcrumbs = [
            ['link' => 'javascript:void(0)', 'name' => "Home"],
            ['link' => 'javascript:void(0)', 'name' => "Social Posters"],
        ];
        return view('livewire.admin.cms.home.social-poster-section', compact('breadcrumbs'))->extends('layouts.admin.app');
    }
}
