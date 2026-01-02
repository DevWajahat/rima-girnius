<div>
    {{-- Styles unchanged ... --}}
    <style>
        /* ... your existing styles ... */
        .star-rating i { font-size: 1.5rem; cursor: pointer; color: #ddd; transition: color 0.2s; }
        .star-rating i.active { color: #ff9f43; }
        .img-thumbnail-wrapper { position: relative; display: inline-block; margin: 5px; }
        .btn-delete-img { position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .avatar-preview { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd; }
    </style>

    {{-- Content Header and Breadcrumbs (unchanged) --}}
    <div class="content-header row">
       {{-- ... --}}
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">Edit Featured Book</h4>
        </div>

        <div class="card-body p-4">
            @session('message') <div class="alert alert-success p-2 mb-3"><i class="fas fa-check"></i> {{ $value }}</div> @endsession
            @session('error') <div class="alert alert-danger p-2 mb-3"><i class="fas fa-exclamation"></i> {{ $value }}</div> @endsession

            {{-- FORM: Removed 'wire:submit' temporarily to debug via manual button click logic if needed,
                 but standard wire:submit is best. Let's keep wire:submit and debug why it fails. --}}
            <form wire:submit="saveFeaturedSection">
                <div class="row g-5">
                    {{-- LEFT COLUMN (Carousel, Inputs) --}}
                    <div class="col-lg-5 col-md-12 border-end-lg">
                         {{-- ... (Images, Category, Title, Price, Author, Rating, Buttons inputs remain unchanged) ... --}}
                         {{-- Just pasting the inputs for brevity, keep your original HTML here --}}
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

                    {{-- RIGHT COLUMN (Heading, Rich Text) --}}
                    <div class="col-lg-7 col-md-12">
                        <div class="mb-4">
                            <label class="form-label fw-bold fs-5">Right Side Heading</label>
                            <input type="text" class="form-control fs-5" placeholder="Main descriptive heading..." wire:model="featuredRightHeading">
                            @error('featuredRightHeading') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Summary Content</label>
                            <div wire:ignore>
                                {{-- IMPORTANT: Removed wire:model completely to rely on manual JS binding --}}
                                <textarea id="froala-featured-summary" class="form-control" rows="10">{{ $featuredRightSummary }}</textarea>
                            </div>
                            @error('featuredRightSummary') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" id="submit-featured-btn" class="btn btn-primary btn-lg px-5">
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

@script
<script>
    const textareaId = 'froala-featured-summary';

    const initEditor = () => {
        console.log("DEBUG: Initializing Editor...");

        // Cleanup ghosts
        if (typeof FroalaEditor !== 'undefined' && FroalaEditor.INSTANCES) {
             const existing = FroalaEditor.INSTANCES.find(i => i.$el[0].id === textareaId);
             if(existing) {
                 console.log("DEBUG: Destroying existing instance");
                 existing.destroy();
             }
        }

        new FroalaEditor(`#${textareaId}`, {
            toolbarButtons: {
                 'moreText': { 'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'clearFormatting'], 'buttonsVisible': 4 },
                 'moreParagraph': { 'buttons': ['alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent'], 'buttonsVisible': 4 },
                 'moreRich': { 'buttons': ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'specialCharacters', 'html'], 'buttonsVisible': 4 },
                 'moreMisc': { 'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'help'], 'buttonsVisible': 2 }
            },
            heightMin: 250,
            events: {
                'contentChanged': function () {
                    const html = this.html.get();
                    console.log("DEBUG: Froala content changed. Length:", html.length);
                    // Defer network request (last arg 'false' means don't send immediately, wait for next submit)
                    $wire.set('featuredRightSummary', html, false);
                },
                'initialized': function() {
                    console.log("DEBUG: Froala Initialized.");
                    const currentVal = $wire.get('featuredRightSummary');
                    if (currentVal && this.html.get() === '') {
                        console.log("DEBUG: Restoring content from Livewire");
                        this.html.set(currentVal);
                    }
                }
            }
        });
    }

    // Initialize
    initEditor();

    // Re-init hooks
    document.addEventListener('livewire:navigated', () => {
        console.log("DEBUG: livewire:navigated");
        setTimeout(initEditor, 100);
    });

    $wire.on('settings-saved', () => {
        console.log("DEBUG: settings-saved event received");
        setTimeout(initEditor, 100);
    });
</script>
@endscript
