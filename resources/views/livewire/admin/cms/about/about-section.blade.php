<div>
    {{-- Internal Styles for Visual Upload --}}
    <style>
        .image-upload-wrapper {
            position: relative;
            width: 100%;
            max-width: 280px;
            margin: 0 auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .image-upload-wrapper:hover {
            transform: translateY(-5px);
        }
        .preview-img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            display: block;
            background-color: #f8f9fa;
        }
        .upload-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.9);
            padding: 15px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        .btn-upload-trigger {
            background: #7367f0;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-upload-trigger:hover {
            background: #5e50ee;
        }
    </style>

    {{-- Breadcrumbs --}}
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">About Page</h2>
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

    {{-- Main Content --}}
    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">Manage About Section</h4>
        </div>

        <div class="card-body p-4">
            {{-- Notifications --}}
            @session('message')
                <div class="alert alert-success p-2 mb-3"><i class="fas fa-check me-2"></i>{{ $value }}</div>
            @endsession
            @session('error')
                <div class="alert alert-danger p-2 mb-3"><i class="fas fa-exclamation-triangle me-2"></i>{{ $value }}</div>
            @endsession

            <form wire:submit="save">
                <div class="row g-5">

                    {{-- LEFT COLUMN: VISUALS --}}
                    <div class="col-lg-4 col-md-5 border-end-lg">
                        <div class="text-center">
                            <h6 class="text-uppercase text-muted fw-bold mb-3">Author Image</h6>

                            <div class="image-upload-wrapper">
                                {{-- 1. New Upload Preview --}}
                                @if ($image)
                                    <img src="{{ $image->temporaryUrl() }}" class="preview-img">

                                {{-- 2. Database Image --}}
                                @elseif($existingImage)
                                    <img src="{{ asset('storage/' . $existingImage) }}" class="preview-img">

                                {{-- 3. Placeholder --}}
                                @else
                                    <div class="preview-img d-flex align-items-center justify-content-center text-secondary">
                                        <div class="text-center">
                                            <i class="far fa-image fa-4x mb-2"></i>
                                            <p class="m-0">No Image Set</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="upload-overlay">
                                    <label class="btn-upload-trigger">
                                        <i class="fas fa-cloud-upload-alt"></i> Change Image
                                        <input type="file" hidden wire:model="image" accept="image/*">
                                    </label>
                                </div>
                            </div>

                            <div class="mt-3 text-muted small">
                                <i class="fas fa-info-circle"></i> Best size: 600x800px (Portrait)<br>
                                Max: 5MB (JPG, PNG, WEBP)
                            </div>
                            @error('image') <span class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: CONTENT --}}
                    <div class="col-lg-8 col-md-7">
                        <h6 class="text-uppercase text-muted fw-bold mb-3">Text Content</h6>

                        {{-- Section Heading --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Section Heading</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                <input type="text" class="form-control form-control-lg"
                                       placeholder="e.g. About the Author"
                                       wire:model="heading">
                            </div>
                            @error('heading') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- Description Editor --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Author Description</label>
                            <div wire:ignore>
                                <textarea id="froala-about-page-desc" class="form-control" rows="8">{{ $description }}</textarea>
                            </div>
                            @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                                <span wire:loading.remove><i class="fas fa-save me-2"></i> Save Changes</span>
                                <span wire:loading><i class="fas fa-spinner fa-spin me-2"></i> Saving...</span>
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

{{-- FROALA JS SCRIPT --}}
@script
<script>
    const editorId = 'froala-about-page-desc';

    const initEditor = () => {
        if (typeof FroalaEditor !== 'undefined' && FroalaEditor.INSTANCES) {
             const existing = FroalaEditor.INSTANCES.find(i => i.$el[0].id === editorId);
             if(existing) existing.destroy();
        }

        new FroalaEditor(`#${editorId}`, {
            toolbarButtons: {
                'moreText': { 'buttons': ['bold', 'italic', 'underline', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor'], 'buttonsVisible': 4 },
                'moreParagraph': { 'buttons': ['alignLeft', 'alignCenter', 'alignRight', 'formatOL', 'formatUL', 'paragraphFormat', 'lineHeight'], 'buttonsVisible': 4 },
                'moreRich': { 'buttons': ['insertLink', 'insertImage', 'emoticons', 'html'], 'buttonsVisible': 3 },
                'moreMisc': { 'buttons': ['undo', 'redo', 'fullscreen'], 'buttonsVisible': 2 }
            },
            heightMin: 300,
            placeholderText: 'Write a compelling description about the author...',
            events: {
                'contentChanged': function () {
                    $wire.set('description', this.html.get(), false);
                },
                'initialized': function() {
                    const currentVal = $wire.get('description');
                    if (currentVal && this.html.get() === '') {
                        this.html.set(currentVal);
                    }
                }
            }
        });
    }

    initEditor();

    document.addEventListener('livewire:navigated', () => { setTimeout(initEditor, 100); });
    $wire.on('settings-saved', () => { setTimeout(initEditor, 100); });
</script>
@endscript
