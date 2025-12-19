<div>
    {{-- 1. ASSETS --}}
    @assets
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css" rel="stylesheet" />
    @endassets

    {{-- 2. STYLES --}}
    <style>
        .livewire-success-message { padding: 10px 15px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 4px; color: #155724; background-color: #d4edda; font-weight: 600; }
        .img-preview-container { margin-top: 10px; border: 1px solid #eee; padding: 5px; display: inline-block; max-width: 200px; }
        .img-preview { max-width: 100%; height: auto; display: block; border-radius: 8px; }
        .trumbowyg-box { background: #fff; border: 1px solid #ddd; border-radius: 8px; min-height: 200px; width: 100%; margin: 0; }

        /* New Card Management Styles */
        .card-manager-item {
            background: #f9fafb; border: 1px solid #e5e7eb; padding: 15px; border-radius: 8px; margin-bottom: 10px;
            display: flex; gap: 15px; align-items: flex-start;
        }
        .card-inputs { flex-grow: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .card-full-width { grid-column: span 2; }
        .btn-remove-card { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; padding: 8px 12px; border-radius: 6px; cursor: pointer; transition: 0.2s; }
        .btn-remove-card:hover { background: #fecaca; }
        .btn-add-card { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; width: 100%; padding: 10px; border-radius: 6px; font-weight: bold; border-style: dashed; }
        .btn-add-card:hover { background: #dcfce7; }
    </style>

    <section class="mt-5 mb-5 my-5" id="about-section-cms">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">About Page: Main Section</h4>
                    </div>
                    <div class="card-body">

                        {{-- Messages --}}
                        @session('message')
                            <div class="livewire-success-message"><i class="fas fa-check-circle me-2"></i> {{ $value }}</div>
                        @endsession
                        @if (session()->has('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        {{-- Form --}}
                        <form class="form form-vertical mt-5 mb-5 my-5" wire:submit.prevent>
                            <div class="row">
                                {{-- 1. Heading --}}
                                <div class="col-12 mb-3">
                                    <label class="form-label"><i class="fas fa-heading me-2"></i> Section Heading</label>
                                    <input type="text" class="form-control" placeholder="e.g. About Our Company" wire:model="sectionHeading">
                                    @error('sectionHeading') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <hr class="my-2">

                                {{-- 2. Image Upload --}}
                                <div class="col-12 mb-3">
                                    <label class="form-label"><i class="fas fa-image me-2"></i> Main Image (JPG, PNG)</label>
                                    {{-- ITERATION KEY FIX: Ensures input clears correctly after save --}}
                                    <div wire:key="image-upload-wrapper-{{ $iteration }}">
                                        <input type="file" class="form-control" id="upload-{{ $iteration }}" wire:model="aboutImage">
                                    </div>
                                    @error('aboutImage') <span class="text-danger d-block">{{ $message }}</span> @enderror

                                    @if ($aboutImage)
                                        <div class="img-preview-container">
                                            <p class="text-info mb-1 small">New:</p>
                                            <img src="{{ $aboutImage->temporaryUrl() }}" class="img-preview">
                                        </div>
                                    @elseif ($existingAboutImage)
                                        <div class="img-preview-container">
                                            <p class="text-info mb-1 small">Current:</p>
                                            <img src="{{ asset('storage/' . $existingAboutImage) }}" class="img-preview">
                                        </div>
                                    @endif
                                </div>

                                <hr class="my-2">

                                {{-- 3. Trumbowyg Editor --}}
                                <div class="col-12 mb-3">
                                    <label class="form-label"><i class="fas fa-align-left me-2"></i> Detailed Description</label>

                                    {{-- WIRE:IGNORE is crucial here --}}
                                    <div wire:ignore>
                                        <textarea id="trumbowyg-about-description" class="form-control">{{ $initialContent }}</textarea>
                                    </div>

                                    @error('aboutDescription') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <hr class="my-2">

                                {{-- 4. Grid Cards Manager (Your New Feature) --}}
                                <div class="col-12 mb-3">
                                    <label class="form-label d-block mb-2">
                                        <i class="fas fa-th-large me-2"></i> Grid Details (Authors/Features)
                                    </label>

                                    <div class="card-manager-container">
                                        @foreach($grid_cards as $index => $card)
                                            <div class="card-manager-item" wire:key="card-{{ $index }}">
                                                <div class="text-center pt-2" style="width: 40px;">
                                                    <i class="{{ $card['icon'] ?: 'ri-question-line' }} fs-4 text-muted"></i>
                                                </div>
                                                <div class="card-inputs">
                                                    {{-- Title --}}
                                                    <div>
                                                        <input type="text" class="form-control form-control-sm"
                                                               placeholder="Title"
                                                               wire:model="grid_cards.{{ $index }}.title">
                                                        @error("grid_cards.{$index}.title") <span class="text-danger small">{{ $message }}</span> @enderror
                                                    </div>

                                                    {{-- Icon Class --}}
                                                    <div>
                                                        <input type="text" class="form-control form-control-sm"
                                                               placeholder="Icon (e.g. ri-user-line)"
                                                               wire:model.live="grid_cards.{{ $index }}.icon">
                                                        @error("grid_cards.{$index}.icon") <span class="text-danger small">{{ $message }}</span> @enderror
                                                    </div>

                                                    {{-- Description --}}
                                                    <div class="card-full-width">
                                                        <textarea class="form-control form-control-sm" rows="2"
                                                                  placeholder="Short Description"
                                                                  wire:model="grid_cards.{{ $index }}.desc"></textarea>
                                                        @error("grid_cards.{$index}.desc") <span class="text-danger small">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <button type="button" class="btn-remove-card" wire:click="removeCard({{ $index }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach

                                        <button type="button" class="btn-add-card" wire:click="addCard">
                                            <i class="fas fa-plus me-1"></i> Add Grid Item
                                        </button>
                                    </div>
                                </div>

                                {{-- Save Button --}}
                                <div class="col-12 mt-4">
                                    <button type="button" class="btn btn-primary" wire:loading.attr="disabled" onclick="syncAndSubmitAboutSection()">
                                        <span wire:loading.remove>Save Changes</span>
                                        <span wire:loading><i class="fas fa-sync fa-spin me-2"></i> Saving...</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- 3. SCRIPTS --}}
@script
<script>
    // 1. Define the Save Function globally
    window.syncAndSubmitAboutSection = () => {
        if (typeof $ !== 'undefined' && $('#trumbowyg-about-description').data('trumbowyg')) {
            const contentToSave = $('#trumbowyg-about-description').trumbowyg('html');
            $wire.saveAboutSection(contentToSave);
        } else {
            const rawContent = document.getElementById('trumbowyg-about-description').value;
            $wire.saveAboutSection(rawContent);
        }
    }

    // 2. Define Initialization Logic
    const initEditor = () => {
        // Safety check: verify jQuery and Trumbowyg are loaded
        if (typeof $ === 'undefined' || !$.fn.trumbowyg) return;

        // Prevent double initialization
        if ($('#trumbowyg-about-description').data('trumbowyg')) return;

        $('#trumbowyg-about-description').trumbowyg({
            btns: [
                ['viewHTML'],
                ['undo', 'redo'],
                ['formatting'],
                ['strong', 'em', 'del'],
                ['link'],
                ['justifyLeft', 'justifyCenter', 'justifyRight'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat'],
                ['fullscreen']
            ],
            tagsToRemoveFromPaste: ['script', 'link']
        });
    };

    // 3. Resource Waiter (Retries until libraries are ready)
    const waitForResources = () => {
        if (typeof $ === 'undefined' || typeof $.fn.trumbowyg === 'undefined') {
            setTimeout(waitForResources, 50);
            return;
        }
        initEditor();
    };

    // 4. Trigger Immediately on Load
    waitForResources();

    // 5. Re-init after Livewire updates (The Fix for disappearing editor)
    document.addEventListener('livewire:initialized', () => {
        // Handle Save Events
        document.addEventListener('settings-saved', () => {
            setTimeout(() => {
                if (!$('.trumbowyg-box').length) {
                    console.log('Restoring Editor after save...');
                    initEditor();
                }
            }, 200);
        });
    });

    // Handle Navigation Events
    document.addEventListener('livewire:navigated', () => {
         waitForResources();
    });
</script>
@endscript
