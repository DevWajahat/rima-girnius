<div>
    {{-- Internal Styles --}}
    <style>
        .image-upload-wrapper {
            position: relative; width: 100%; max-width: 280px; margin: 0 auto;
            border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .image-upload-wrapper:hover { transform: translateY(-5px); }
        .preview-img {
            width: 100%; height: 320px; object-fit: cover; display: block; background-color: #f8f9fa;
        }
        .upload-overlay {
            position: absolute; bottom: 0; left: 0; right: 0; background: rgba(255, 255, 255, 0.9);
            padding: 15px; text-align: center; border-top: 1px solid #eee;
        }
        .btn-upload-trigger {
            background: #7367f0; color: white; border: none; padding: 8px 20px;
            border-radius: 20px; font-size: 0.9rem; cursor: pointer; transition: background 0.2s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-upload-trigger:hover { background: #5e50ee; }

        /* Summernote Fixes */
        .note-editor.note-frame { border-radius: 0.375rem; border-color: #d1d5db; }
        .note-modal-backdrop { display: none !important; }
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
            @session('message')
                <div class="alert alert-success p-2 mb-3"><i class="fas fa-check me-2"></i>{{ $value }}</div>
            @endsession
            @session('error')
                <div class="alert alert-danger p-2 mb-3"><i class="fas fa-exclamation-triangle me-2"></i>{{ $value }}</div>
            @endsession

            <form wire:submit="save">
                <div class="row g-5">

                    {{-- LEFT: IMAGE --}}
                    <div class="col-lg-4 col-md-5 border-end-lg">
                        <div class="text-center">
                            <h6 class="text-uppercase text-muted fw-bold mb-3">Author Image</h6>
                            <div class="image-upload-wrapper">
                                @if ($aboutImage)
                                    <img src="{{ $aboutImage->temporaryUrl() }}" class="preview-img">
                                @elseif($existingImage)
                                    <img src="{{ asset('storage/' . $existingImage) }}" class="preview-img">
                                @else
                                    <div class="preview-img d-flex align-items-center justify-content-center text-secondary">
                                        <div class="text-center">
                                            <i class="far fa-image fa-4x mb-2"></i><p class="m-0">No Image Set</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="upload-overlay">
                                    <label class="btn-upload-trigger">
                                        <i class="fas fa-cloud-upload-alt"></i> Change Image
                                        <input type="file" hidden wire:model="aboutImage" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            @error('aboutImage') <span class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- RIGHT: CONTENT --}}
                    <div class="col-lg-8 col-md-7">
                        <h6 class="text-uppercase text-muted fw-bold mb-3">Text Content</h6>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Section Heading</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                <input type="text" class="form-control form-control-lg" placeholder="e.g. About the Author" wire:model="aboutHeading">
                            </div>
                            @error('aboutHeading') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- SUMMERNOTE EDITOR (Asynchronous Loader) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Author Description</label>

                            <div wire:ignore
                                 x-data="{
                                    value: @entangle('aboutDescription'),
                                    isLoaded: false,
                                    init() {
                                        // 1. Inject CSS immediately
                                        if (!document.querySelector('link[href*=\'summernote\']')) {
                                            let link = document.createElement('link');
                                            link.href = 'https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css';
                                            link.rel = 'stylesheet';
                                            document.head.appendChild(link);
                                        }

                                        // 2. Define Script Loader Promise
                                        const loadScript = (src) => {
                                            return new Promise((resolve, reject) => {
                                                if (document.querySelector(`script[src='${src}']`)) {
                                                    resolve(); return;
                                                }
                                                let script = document.createElement('script');
                                                script.src = src;
                                                script.onload = resolve;
                                                script.onerror = reject;
                                                document.head.appendChild(script);
                                            });
                                        };

                                        // 3. Load Sequence: jQuery -> Summernote -> Init
                                        const loadDependencies = async () => {
                                            if (typeof jQuery === 'undefined') {
                                                await loadScript('https://code.jquery.com/jquery-3.6.0.min.js');
                                            }
                                            if (typeof jQuery.fn.summernote === 'undefined') {
                                                await loadScript('https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js');
                                            }
                                            this.initEditor();
                                        };

                                        loadDependencies();
                                    },
                                    initEditor() {
                                        this.isLoaded = true;
                                        let $editor = $(this.$refs.editor);

                                        if ($editor.data('summernote')) {
                                            $editor.summernote('destroy');
                                        }

                                        $editor.summernote({
                                            placeholder: 'Write a compelling description...',
                                            tabsize: 2,
                                            height: 300,
                                            dialogsInBody: true,
                                            toolbar: [
                                                ['style', ['style']],
                                                ['font', ['bold', 'underline', 'clear']],
                                                ['fontname', ['fontname']],
                                                ['fontsize', ['fontsize']],
                                                ['color', ['color']],
                                                ['para', ['ul', 'ol', 'paragraph', 'height']],
                                                ['table', ['table']],
                                                ['insert', ['link', 'picture', 'video', 'hr']],
                                                ['view', ['fullscreen', 'codeview', 'help']]
                                            ],
                                            callbacks: {
                                                onChange: (contents) => {
                                                    this.value = contents;
                                                }
                                            }
                                        });

                                        if (this.value) {
                                            $editor.summernote('code', this.value);
                                        }

                                        this.$watch('value', (newValue) => {
                                            if ($editor.summernote('code') != newValue) {
                                                $editor.summernote('code', newValue);
                                            }
                                        });
                                    }
                                 }"
                            >
                                {{-- Loading State Visual --}}
                                <div x-show="!isLoaded" class="text-center p-3 text-muted bg-light border rounded">
                                    <i class="fas fa-spinner fa-spin me-2"></i> Loading Editor...
                                </div>

                                {{-- The Editor --}}
                                <textarea x-ref="editor" class="form-control" style="display:none;"></textarea>
                            </div>
                            @error('aboutDescription') <span class="text-danger small">{{ $message }}</span> @enderror
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
