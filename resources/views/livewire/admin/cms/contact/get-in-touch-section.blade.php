<div>
    {{-- Internal Styles --}}
    <style>
        /* Summernote Fixes */
        .note-editor.note-frame { border-radius: 0.375rem; border-color: #d1d5db; }
        .note-modal-backdrop { display: none !important; }
    </style>

    {{-- Breadcrumbs --}}
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Contact Page Settings</h2>
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

    {{-- Main Form --}}
    <form wire:submit="save">

        {{-- SECTION 1: TOP HEADER --}}
        <div class="card mb-4">
            <div class="card-header border-bottom">
                <h4 class="card-title text-primary"><i class="fas fa-heading me-2"></i>Page Header</h4>
            </div>
            <div class="card-body p-4">
                @session('message')
                    <div class="alert alert-success p-2 mb-3"><i class="fas fa-check me-2"></i>{{ $value }}</div>
                @endsession

                <div class="row text-center justify-content-center">
                    <div class="col-md-8">
                        {{-- Main Heading --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Main Page Heading</label>
                            <input type="text" class="form-control form-control-lg text-center fw-bold fs-4"
                                   wire:model="mainHeading" placeholder="Contact">
                            @error('mainHeading') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- Sub Heading --}}
                        <div class="mb-2">
                            <label class="form-label">Sub Heading Text</label>
                            <textarea class="form-control text-center" rows="2"
                                      wire:model="mainSubHeading"
                                      placeholder="Have a question about the book, or just want to say hello?"></textarea>
                            @error('mainSubHeading') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- SECTION 2: LEFT CONTENT INFO --}}
            <div class="col-md-8 col-12">
                <div class="card h-100">
                    <div class="card-header border-bottom">
                        <h4 class="card-title"><i class="fas fa-info-circle me-2"></i>Contact Details (Left Column)</h4>
                    </div>
                    <div class="card-body p-4">

                        {{-- Content Heading --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Section Heading</label>
                            <input type="text" class="form-control fs-5" wire:model="contentHeading" placeholder="Get in Touch">
                            @error('contentHeading') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- SUMMERNOTE EDITOR --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Description Text</label>

                            <div wire:ignore
                                 x-data="{
                                    value: @entangle('contentDescription'),
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
                                            placeholder: 'Write the Get in Touch description...',
                                            tabsize: 2,
                                            height: 200,
                                            dialogsInBody: true,
                                            toolbar: [
                                                ['style', ['style']],
                                                ['font', ['bold', 'underline', 'clear']],
                                                ['para', ['ul', 'ol', 'paragraph']],
                                                ['insert', ['link', 'hr']],
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
                            @error('contentDescription') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <hr>

                        <div class="row g-3">
                            {{-- Email --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email Address</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" wire:model="email" placeholder="name@example.com">
                                </div>
                                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            {{-- Location --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Location</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" class="form-control" wire:model="location" placeholder="City, Country">
                                </div>
                                @error('location') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- SECTION 3: SOCIAL MEDIA --}}
            <div class="col-md-4 col-12">
                <div class="card h-100">
                    <div class="card-header border-bottom">
                        <h4 class="card-title"><i class="fas fa-share-alt me-2"></i>Social Links</h4>
                    </div>
                    <div class="card-body p-4">

                        {{-- Instagram --}}
                        <div class="mb-3">
                            <label class="form-label">Instagram URL</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text bg-light"><i class="fab fa-instagram text-danger"></i></span>
                                <input type="url" class="form-control" wire:model="socialInstagram" placeholder="https://instagram.com/...">
                            </div>
                            @error('socialInstagram') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- X / Twitter --}}
                        <div class="mb-3">
                            <label class="form-label">X (Twitter) URL</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text bg-light"><i class="fab fa-twitter text-dark"></i></span>
                                <input type="url" class="form-control" wire:model="socialX" placeholder="https://x.com/...">
                            </div>
                            @error('socialX') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- Facebook --}}
                        <div class="mb-4">
                            <label class="form-label">Facebook URL</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text bg-light"><i class="fab fa-facebook text-primary"></i></span>
                                <input type="url" class="form-control" wire:model="socialFacebook" placeholder="https://facebook.com/...">
                            </div>
                            @error('socialFacebook') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <span wire:loading.remove>Save All Settings</span>
                                <span wire:loading>Saving...</span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
