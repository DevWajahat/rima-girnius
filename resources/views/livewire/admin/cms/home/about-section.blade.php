<div>
    {{-- CSS links kept minimal --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    {{-- NOTE: CDN links removed from here as they are in the main layout --}}

    <style>
        /* Styles to keep the view clean and centered */
        #about-section-cms .card { margin-left: auto; margin-right: auto; max-width: 100%; }
        .content-body .row { margin-left: 0; margin-right: 0; padding: 0; }
        #about-section-cms { overflow-x: hidden; }
        .input-group-text { width: 40px; justify-content: center; }

        /* Custom Style for Simple Success Message */
        .livewire-success-message {
            padding: 10px 15px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            color: #155724;
            background-color: #d4edda;
            font-weight: 600;
        }

        .img-preview-container {
            margin-top: 10px;
            border: 1px solid #eee;
            padding: 5px;
            display: inline-block;
            max-width: 200px;
        }

        .img-preview {
            max-width: 100%;
            height: auto;
            display: block;
            border-radius: 50%;
        }
    </style>

    <section class="mt-5 mb-5 my-5" id="about-section-cms">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Home About Section Content (About The Author)</h4>
                    </div>
                    <div class="card-body">

                        {{-- Success Message --}}
                        @session('message')
                            <div class="livewire-success-message">
                                <i class="fas fa-check-circle me-2"></i> {{ $value }}
                            </div>
                        @endsession

                        {{-- Error Message --}}
                        @if (session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- The Livewire Form (Removed wire:submit.prevent) --}}
                        <form class="form form-vertical mt-5 mb-5 my-5">
                            <div class="row">

                                {{-- 1. Section Heading Input --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label d-flex align-items-center">
                                            <i class="fas fa-signature me-2"></i> Section Heading (e.g., About The Author)
                                        </label>
                                        <input type="text" class="form-control" placeholder="Enter the main heading for this section..." wire:model.defer="sectionHeading">
                                        @error('sectionHeading') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <hr class="my-2">

                                {{-- 2. Author Image Upload --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label d-flex align-items-center" for="authorImage">
                                            <i class="fas fa-user-circle me-2"></i> Author Profile Image (JPG, PNG, max 2MB)
                                            @if ($existingAuthorImage)
                                                <small class="ms-2 text-muted">(Current Image set)</small>
                                            @endif
                                        </label>
                                        <input type="file" id="authorImage" class="form-control" wire:model="authorImage">
                                        <small class="form-text text-muted">Upload a new image to replace the current one. Required on initial setup.</small>
                                        @error('authorImage') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                {{-- Image Preview/Existing Image Display --}}
                                <div class="col-12 mb-3">
                                    @if ($authorImage)
                                        <p class="text-info mt-2"><i class="fas fa-spinner fa-spin me-2"></i> New Image Preview:</p>
                                        <div class="img-preview-container">
                                            <img src="{{ $authorImage->temporaryUrl() }}" class="img-preview" style="width: 150px; height: 150px; object-fit: cover;" alt="New Image Preview">
                                        </div>
                                    @elseif ($existingAuthorImage)
                                        <p class="text-info mt-2"><i class="fas fa-eye me-2"></i> Current Image:</p>
                                        <div class="img-preview-container">
                                            <img src="{{ asset('storage/' . $existingAuthorImage) }}" class="img-preview" style="width: 150px; height: 150px; object-fit: cover;" alt="Current Author Image">
                                        </div>
                                    @endif
                                </div>

                                <hr class="my-2">

                                {{-- 3. Author Brief Textarea --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label d-flex align-items-center">
                                            <i class="fas fa-file-alt me-2"></i> Brief Paragraph About The Author
                                        </label>
{{-- Add wire:key to help Livewire track this element distinctively --}}
<div wire:ignore wire:key="froala-editor-container">
    <textarea id="froala-author-brief" class="form-control" rows="5">{{ $initialContent }}</textarea>
</div>
                                        @error('authorBrief') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>


                                {{-- Save Button (Changed to call JS function) --}}
                                <div class="col-12 mt-3">
                                    <button type="button"
                                        class="btn btn-primary waves-effect waves-float waves-light me-1"
                                        wire:loading.attr="disabled"
                                        onclick="syncAndSubmit()">
                                        <span wire:loading.remove>Save About Section</span>
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

@script
<script>
    // 1. GLOBAL FUNCTION: Atomic Save
    window.syncAndSubmit = () => {
        const Froala = window.FroalaEditor;
        const textarea = document.getElementById('froala-author-brief');

        let contentToSave = '';

        // Try to get content from Froala instance
        if (typeof Froala !== 'undefined' && Froala.instances) {
            const editor = Array.from(Froala.instances).find(instance =>
                instance.$el[0].id === 'froala-author-brief'
            );

            if (editor) {
                contentToSave = editor.html.get();
            } else if (textarea) {
                contentToSave = textarea.value;
            }
        } else if (textarea) {
            contentToSave = textarea.value;
        }

        // ONE REQUEST: Send content directly to the PHP method.
        // This stops the multiple request loop and flash message disappearance.
        @this.saveAboutSection(contentToSave);
    };

    // 2. INITIALIZATION LOGIC
    document.addEventListener('livewire:initialized', () => {

        const initFroala = () => {
            const Froala = window.FroalaEditor;
            const textareaId = 'froala-author-brief';
            const textarea = document.getElementById(textareaId);

            if (!textarea) return;

            // CLEANUP: Destroy zombies
            if (Froala.instances) {
                Array.from(Froala.instances).forEach(instance => {
                    if (instance.$el[0].id === textareaId) {
                        instance.destroy();
                    }
                });
            }

            // RESET DOM
            if (textarea.classList.contains('fr-initialized')) {
                textarea.classList.remove('fr-initialized');
            }

            // INITIALIZE
            try {
                new Froala(`#${textareaId}`, {
                    toolbarButtons: {
                        'moreText': {
                            'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'clearFormatting'],
                            'buttonsVisible': 4
                        },
                        'moreParagraph': {
                            'buttons': ['alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent'],
                            'buttonsVisible': 4
                        },
                        'moreRich': {
                            'buttons': ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'specialCharacters', 'html'],
                            'buttonsVisible': 4
                        },
                        'moreMisc': {
                            'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'help'],
                            'buttonsVisible': 2
                        }
                    },
                    heightMin: 200,
                    events: {
                        // NOTE: We REMOVED the 'contentChanged' listener here.
                        // Since we are passing data directly on Submit, we don't need
                        // continuous background requests causing conflicts.
                    }
                });
            } catch (e) {
                console.error("Froala Init Error:", e);
            }
        };

        // Run on Load
        initFroala();

        // Run ONLY when Settings are Saved
        document.addEventListener('settings-saved', () => {
            // Wait for Livewire to finish DOM updates (flash message, etc)
            setTimeout(() => {
                initFroala();
            }, 100);
        });
    });
</script>
@endscript
