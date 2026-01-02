<div>
    {{-- Internal Styles for Profile Picture (PFP) --}}
    <style>
        .pfp-preview-container {
            width: 150px;
            height: 150px;
            position: relative;
            margin: 0 auto;
        }
        .pfp-preview {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #e9ecef;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .pfp-upload-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: #7367f0;
            color: white;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .pfp-upload-btn:hover {
            transform: scale(1.1);
            background: #5e50ee;
        }
    </style>

    {{-- Breadcrumbs --}}
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Home About Section</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            @foreach ($breadcrumbs as $crumb)
                                <li class="breadcrumb-item"><a href="{{ $crumb['link'] }}">{{ $crumb['name'] }}</a></li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">Edit Author Details</h4>
        </div>

        <div class="card-body p-4">
            {{-- Flash Messages --}}
            @session('message')
                <div class="alert alert-success p-2 mb-3"><i class="fas fa-check"></i> {{ $value }}</div>
            @endsession
            @session('error')
                <div class="alert alert-danger p-2 mb-3"><i class="fas fa-exclamation"></i> {{ $value }}</div>
            @endsession

            {{-- Form Start --}}
            <form wire:submit="saveAboutSection">
                <div class="row g-4">

                    {{-- LEFT COL: Image Upload --}}
                    <div class="col-md-4 text-center border-end-md">
                        <label class="form-label fw-bold mb-3">Profile Picture</label>

                        <div class="pfp-preview-container mb-3">
                            {{-- 1. Check for NEW upload --}}
                            @if ($aboutImage)
                                <img src="{{ $aboutImage->temporaryUrl() }}" class="pfp-preview">

                            {{-- 2. Check for EXISTING saved image --}}
                            @elseif($existingAboutImage)
                                <img src="{{ asset('storage/' . $existingAboutImage) }}" class="pfp-preview">

                            {{-- 3. Default Placeholder --}}
                            @else
                                <div class="pfp-preview d-flex align-items-center justify-content-center bg-light text-secondary">
                                    <i class="fas fa-user fa-3x"></i>
                                </div>
                            @endif

                            {{-- Hidden File Input Trigger --}}
                            <label class="pfp-upload-btn" title="Upload New Image">
                                <i class="fas fa-camera"></i>
                                <input type="file" hidden wire:model="aboutImage" accept="image/*">
                            </label>
                        </div>

                        <div class="small text-muted">
                            Allowed: JPG, PNG, WEBP.<br>Max size: 5MB.
                        </div>
                        @error('aboutImage')
                            <span class="text-danger d-block mt-2 small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- RIGHT COL: Inputs & Editor --}}
                    <div class="col-md-8">
                        {{-- Heading Input --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Section Heading</label>
                            <input type="text" class="form-control fs-5" placeholder="e.g. Meet the Author" wire:model="aboutHeading">
                            @error('aboutHeading') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- Description Editor (Froala) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Author Description</label>

                            {{-- wire:ignore prevents Livewire from refreshing this div and killing the editor --}}
                            <div wire:ignore>
                                <textarea id="froala-about-description" class="form-control" rows="10">{{ $aboutDescription }}</textarea>
                            </div>
                            @error('aboutDescription') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- Save Button --}}
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-5">
                                <span wire:loading.remove>Save Changes</span>
                                <span wire:loading>Saving...</span>
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

{{-- JS SCRIPT FOR FROALA INTEGRATION --}}
@script
<script>
    const aboutEditorId = 'froala-about-description';

    const initAboutEditor = () => {
        // Cleanup ghosts to prevent duplicates
        if (typeof FroalaEditor !== 'undefined' && FroalaEditor.INSTANCES) {
             const existing = FroalaEditor.INSTANCES.find(i => i.$el[0].id === aboutEditorId);
             if(existing) existing.destroy();
        }

        new FroalaEditor(`#${aboutEditorId}`, {
            toolbarButtons: {
                 'moreText': { 'buttons': ['bold', 'italic', 'underline', 'fontFamily', 'fontSize', 'textColor'], 'buttonsVisible': 3 },
                 'moreParagraph': { 'buttons': ['alignLeft', 'alignCenter', 'alignRight', 'formatOL', 'formatUL', 'paragraphFormat'], 'buttonsVisible': 3 },
                 'moreRich': { 'buttons': ['insertLink', 'insertImage', 'emoticons', 'html'], 'buttonsVisible': 3 },
                 'moreMisc': { 'buttons': ['undo', 'redo', 'fullscreen'], 'buttonsVisible': 2 }
            },
            heightMin: 200,
            events: {
                'contentChanged': function () {
                    const html = this.html.get();
                    // Sync content to Livewire property (defer: false means send on next request)
                    $wire.set('aboutDescription', html, false);
                },
                'initialized': function() {
                    // Populate editor on load if Livewire has data but editor is empty
                    const currentVal = $wire.get('aboutDescription');
                    if (currentVal && this.html.get() === '') {
                        this.html.set(currentVal);
                    }
                }
            }
        });
    }

    // Initialize on page load
    initAboutEditor();

    // Re-initialize on Livewire navigation (SPA mode)
    document.addEventListener('livewire:navigated', () => { setTimeout(initAboutEditor, 100); });

    // Re-initialize after save to ensure editor stays active
    $wire.on('settings-saved', () => { setTimeout(initAboutEditor, 100); });
</script>
@endscript
