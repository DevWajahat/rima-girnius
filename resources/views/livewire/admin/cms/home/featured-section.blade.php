<div>
    {{-- Internal Styles --}}
    <style>
        .star-rating i { font-size: 1.5rem; cursor: pointer; color: #ddd; transition: color 0.2s; }
        .star-rating i.active { color: #ff9f43; }
        .img-thumbnail-wrapper { position: relative; display: inline-block; margin: 5px; }
        .btn-delete-img { position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .avatar-preview { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd; }

        /* Summernote Fixes from Reference */
        .note-editor.note-frame { border-radius: 0.375rem; border-color: #d1d5db; }
        .note-modal-backdrop { display: none !important; }
    </style>

    {{-- Breadcrumbs --}}
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Featured Book</h2>
                    <div class="breadcrumb-wrapper">
                        {{-- Add your breadcrumbs here if needed --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">Edit Featured Book</h4>
        </div>

        <div class="card-body p-4">
            @session('message') <div class="alert alert-success p-2 mb-3"><i class="fas fa-check"></i> {{ $value }}</div> @endsession
            @session('error') <div class="alert alert-danger p-2 mb-3"><i class="fas fa-exclamation"></i> {{ $value }}</div> @endsession

            <form wire:submit="saveFeaturedSection">
                <div class="row g-5">
                    {{-- LEFT COLUMN --}}
                    <div class="col-lg-5 col-md-12 border-end-lg">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Carousel Images</label>
                            <div class="mb-2 p-2 bg-light rounded">
                                @if(count($existingFeaturedImages) > 0)
                                    @foreach($existingFeaturedImages as $index => $img)
                                        <div class="img-thumbnail-wrapper">
                                            <img src="{{ asset('storage/'.$img) }}" height="60" class="rounded">
                                            <span class="btn-delete-img" wire:click="removeImage({{ $index }})"><i class="fas fa-times"></i></span>
                                        </div>
                                    @endforeach
                                @else <small class="text-muted fst-italic">No images saved.</small> @endif
                            </div>
                            <input type="file" class="form-control" wire:model="newFeaturedImages" multiple accept="image/*">
                            @error('newFeaturedImages.*') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-uppercase text-muted">Category</label>
                            <input type="text" class="form-control" placeholder="Add Category" wire:model="featuredCategory">
                            @error('featuredCategory') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Book Title</label>
                            <input type="text" class="form-control fs-5 fw-bold" placeholder="e.g. Eureka And The Magical Trio" wire:model="featuredTitle">
                            @error('featuredTitle') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label">Regular Price ($)</label>
                                <input type="number" step="0.01" class="form-control" wire:model="featuredPrice">
                                @error('featuredPrice') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label">Discount Price ($)</label>
                                <input type="number" step="0.01" class="form-control" placeholder="Optional" wire:model="featuredDiscountPrice">
                            </div>
                        </div>

                        <div class="mb-3 p-3 border rounded">
                            <label class="form-label fw-bold mb-2">Author Info</label>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @if ($featuredAuthorAvatar)
                                        <img src="{{ $featuredAuthorAvatar->temporaryUrl() }}" class="avatar-preview">
                                    @elseif($existingAuthorAvatar)
                                        <img src="{{ asset('storage/' . $existingAuthorAvatar) }}" class="avatar-preview">
                                    @else
                                        <div class="avatar-preview d-flex align-items-center justify-content-center bg-secondary text-white"><i class="fas fa-user"></i></div>
                                    @endif
                                    <div class="mt-1">
                                        <label class="btn btn-sm btn-outline-primary p-0 px-1 w-100" style="font-size: 10px;">
                                            Upload <input type="file" hidden wire:model="featuredAuthorAvatar">
                                        </label>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control" placeholder="Author Name" wire:model="featuredAuthorName">
                                    @error('featuredAuthorName') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Rating ({{ $featuredBookRating }} / 5)</label>
                            <div class="star-rating">
                                @foreach(range(1, 5) as $i)
                                    <i class="fas fa-star {{ $i <= $featuredBookRating ? 'active' : '' }}" wire:click="setRating({{ $i }})"></i>
                                @endforeach
                            </div>
                        </div>

                        <label class="form-label fw-bold mt-2">Action Buttons</label>
                        <div class="row g-2 mb-2">
                            <div class="col-4"><input type="text" class="form-control form-control-sm" placeholder="Btn 1 Text" wire:model="featuredBtn1Text"></div>
                            <div class="col-8"><input type="text" class="form-control form-control-sm" placeholder="Btn 1 Link" wire:model="featuredBtn1Link"></div>
                        </div>
                        <div class="row g-2">
                            <div class="col-4"><input type="text" class="form-control form-control-sm" placeholder="Btn 2 Text" wire:model="featuredBtn2Text"></div>
                            <div class="col-8"><input type="text" class="form-control form-control-sm" placeholder="Btn 2 Link" wire:model="featuredBtn2Link"></div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="col-lg-7 col-md-12">
                        <div class="mb-4">
                            <label class="form-label fw-bold fs-5">Right Side Heading</label>
                            <input type="text" class="form-control fs-5" placeholder="Main descriptive heading..." wire:model="featuredRightHeading">
                            @error('featuredRightHeading') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- SUMMERNOTE EDITOR --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Summary Content</label>

                            <div wire:ignore
                                 x-data="{
                                    value: @entangle('featuredRightSummary'),
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
                                            placeholder: 'Write the featured book summary here...',
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
                            @error('featuredRightSummary') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <span wire:loading.remove>Save Featured Section</span>
                                <span wire:loading>Saving...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
