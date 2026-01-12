<div>
    {{-- 1. STYLES --}}
    <style>
        .pfp-preview-container { width: 150px; height: 150px; position: relative; margin: 0 auto; }
        .pfp-preview { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 4px solid #e9ecef; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .pfp-upload-btn { position: absolute; bottom: 5px; right: 5px; background: #7367f0; color: white; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
        .pfp-upload-btn:hover { transform: scale(1.1); background: #5e50ee; }

        /* Summernote Overrides */
        .note-editor.note-frame { border-radius: 0.375rem; border-color: #d1d5db; }
        .note-modal-backdrop { display: none !important; }
        .note-toolbar { z-index: 50; }
    </style>

    {{-- 2. BREADCRUMBS --}}
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

    {{-- 3. MAIN CARD --}}
    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">Edit Author Details</h4>
        </div>

        <div class="card-body p-4">
            @session('message')
                <div class="alert alert-success p-2 mb-3"><i class="fas fa-check"></i> {{ $value }}</div>
            @endsession
            @session('error')
                <div class="alert alert-danger p-2 mb-3"><i class="fas fa-exclamation"></i> {{ $value }}</div>
            @endsession

            <form wire:submit="saveAboutSection">
                <div class="row g-4">
                    {{-- LEFT COL: Image --}}
                    <div class="col-md-4 text-center border-end-md">
                        <label class="form-label fw-bold mb-3">Profile Picture</label>
                        <div class="pfp-preview-container mb-3">
                            @if ($aboutImage)
                                <img src="{{ $aboutImage->temporaryUrl() }}" class="pfp-preview">
                            @elseif($existingAboutImage)
                                <img src="{{ asset('storage/' . $existingAboutImage) }}" class="pfp-preview">
                            @else
                                <div class="pfp-preview d-flex align-items-center justify-content-center bg-light text-secondary">
                                    <i class="fas fa-user fa-3x"></i>
                                </div>
                            @endif
                            <label class="pfp-upload-btn">
                                <i class="fas fa-camera"></i>
                                <input type="file" hidden wire:model="aboutImage" accept="image/*">
                            </label>
                        </div>
                        <div class="small text-muted">Allowed: JPG, PNG, WEBP. Max: 5MB.</div>
                        @error('aboutImage') <span class="text-danger d-block mt-2 small">{{ $message }}</span> @enderror
                    </div>

                    {{-- RIGHT COL: Inputs --}}
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Section Heading</label>
                            <input type="text" class="form-control fs-5" placeholder="e.g. Meet the Author" wire:model="aboutHeading">
                            @error('aboutHeading') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- SUMMERNOTE EDITOR --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Author Description</label>

                            <div wire:ignore
                                 x-data="{
                                    value: @entangle('aboutDescription'),
                                    isLoaded: false,
                                    init() {
                                        // 1. Asset Loading (CSS)
                                        if (!document.querySelector('link[href*=\'summernote\']')) {
                                            let link = document.createElement('link');
                                            link.href = 'https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css';
                                            link.rel = 'stylesheet';
                                            document.head.appendChild(link);
                                        }

                                        // 2. Asset Loading (JS)
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

                                        // 3. Initialize Chain
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

                                        // 4. CRITICAL FIX: Cleanup when navigating away
                                        // This ensures the editor is destroyed so it can be re-created on return
                                        document.addEventListener('livewire:navigating', () => {
                                            if ($(this.$refs.editor).data('summernote')) {
                                                $(this.$refs.editor).summernote('destroy');
                                            }
                                        }, { once: true });
                                    },
                                    initEditor() {
                                        this.isLoaded = true;
                                        let $editor = $(this.$refs.editor);

                                        // Safety check: destroy previous instance if it lingers
                                        if ($editor.data('summernote')) {
                                            $editor.summernote('destroy');
                                        }

                                        $editor.summernote({
                                            placeholder: 'Write a compelling description...',
                                            tabsize: 2,
                                            height: 250,
                                            dialogsInBody: true,
                                            toolbar: [
                                                ['style', ['style']],
                                                ['font', ['bold', 'underline', 'clear']],
                                                ['fontsize', ['fontsize']],
                                                ['color', ['color']],
                                                ['para', ['ul', 'ol', 'paragraph']],
                                                ['insert', ['link', 'picture']],
                                                ['view', ['fullscreen', 'codeview']]
                                            ],
                                            callbacks: {
                                                onChange: (contents) => {
                                                    this.value = contents;
                                                }
                                            }
                                        });

                                        // Set initial value
                                        if (this.value) {
                                            $editor.summernote('code', this.value);
                                        }

                                        // Watch for updates
                                        this.$watch('value', (newValue) => {
                                            if ($editor.summernote('code') !== newValue) {
                                                $editor.summernote('code', newValue);
                                            }
                                        });
                                    }
                                 }"
                            >
                                <div x-show="!isLoaded" class="text-center p-3 text-muted bg-light border rounded">
                                    <i class="fas fa-spinner fa-spin me-2"></i> Loading Editor...
                                </div>

                                <textarea x-ref="editor" class="form-control" style="display:none;"></textarea>
                            </div>

                            @error('aboutDescription') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

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
