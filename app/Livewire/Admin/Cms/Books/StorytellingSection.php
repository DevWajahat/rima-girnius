<?php

namespace App\Livewire\Admin\Cms\Books;

use App\Models\Cms;
use App\Models\CmsMeta;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StorytellingSection extends Component
{
    // Properties
    public string $sectionHeading = '';

    // Kept untyped initially to handle array hydration, but cast to string in logic
    public $storytellingContent = '';

    private string $pageKey = 'books';
    private string $sectionKey = 'storytelling-section';

    protected $rules = [
        'sectionHeading'      => 'required|string|max:255',
        'storytellingContent' => 'required|string|max:20000', // Increased limit for long stories
    ];

    private function getCmsRecord()
    {
        return Cms::where('page', $this->pageKey)
                    ->where('type', $this->sectionKey)
                    ->first();
    }

    public function mount()
    {
        $cmsRecord = $this->getCmsRecord();
        $data = [];

        if ($cmsRecord) {
            $metaData = CmsMeta::where('cms_id', $cmsRecord->id)->get();
            $data = $metaData->pluck('meta_value', 'meta_key')->toArray();
        }

        $this->sectionHeading      = (string) ($data['sectionHeading'] ?? 'The Power of Storytelling');
        $this->storytellingContent = (string) ($data['storytellingContent'] ?? '');
    }

    public function updatedStorytellingContent($value)
    {
        if (is_array($value)) {
            $this->storytellingContent = json_encode($value);
        }
    }

    public function saveStorytellingSection($contentFromFrontend = null)
    {
        // 1. Accept content directly from JS to fix race conditions
        if ($contentFromFrontend !== null) {
            $this->storytellingContent = $contentFromFrontend;
        }

        // 2. Sanity Check
        if (is_array($this->storytellingContent)) {
            $this->storytellingContent = empty($this->storytellingContent) ? '' : json_encode($this->storytellingContent);
        }

        $this->validate();

        $cmsRecord = $this->getCmsRecord();

        if (!$cmsRecord) {
            session()->flash('error', 'Error: Parent CMS record not found for Books > Storytelling Section.');
            return;
        }

        $cmsId = $cmsRecord->id;

        $inputData = [
            'sectionHeading'      => $this->sectionHeading,
            'storytellingContent' => $this->storytellingContent,
        ];

        DB::beginTransaction();
        try {
            foreach ($inputData as $meta_key => $meta_value) {
                CmsMeta::updateOrCreate(
                    ['cms_id' => $cmsId, 'meta_key' => $meta_key],
                    ['meta_value' => (string) $meta_value]
                );
            }
            DB::commit();

            session()->flash('message', 'Storytelling section updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Database error: ' . $e->getMessage());
        }

        $this->dispatch('settings-saved');
    }

    public function render()
    {
        // Force-cast to string for safe rendering in View
        $safeContent = is_array($this->storytellingContent)
            ? json_encode($this->storytellingContent)
            : (string) $this->storytellingContent;

        return view('livewire.admin.cms.books.storytelling-section', [
            'initialContent' => $safeContent
        ]);
    }
}
