<div>
    {{-- CSS links kept minimal --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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

                        {{-- The Livewire Form --}}
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
                                        {{-- Wire:ignore is CRITICAL here --}}
                                        <div wire:ignore wire:key="froala-editor-container">
                                            <textarea id="froala-author-brief" class="form-control" rows="5">{{ $initialContent }}</textarea>
                                        </div>
                                        @error('authorBrief') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>


                                {{-- Save Button --}}
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
    /**
     * 1. Global Sync Function
     * Accessible via onclick attribute in HTML
     */
    window.syncAndSubmit = () => {
        const Froala = window.FroalaEditor;
        const textareaId = 'froala-author-brief';
        const textarea = document.getElementById(textareaId);
        let contentToSave = '';

        // Safely extract content
        if (typeof Froala !== 'undefined' && Froala.instances) {
            // Find the specific instance for this textarea
            const editor = Array.from(Froala.instances).find(instance =>
                instance.$el && instance.$el[0].id === textareaId
            );

            if (editor) {
                contentToSave = editor.html.get();
            } else if (textarea) {
                contentToSave = textarea.value;
            }
        } else if (textarea) {
            contentToSave = textarea.value;
        }

        // Pass data to Livewire
        @this.saveAboutSection(contentToSave);
    };

    /**
     * 2. Logic Controller
     * Encapsulates all editor logic to keep global scope clean
     */
    const FroalaManager = {
        textareaId: 'froala-author-brief',

        init: function() {
            // Safety Check: Are resources loaded?
            if (typeof window.FroalaEditor === 'undefined') {
                console.warn('Froala not loaded yet, retrying...');
                setTimeout(() => this.init(), 100);
                return;
            }

            const textarea = document.getElementById(this.textareaId);
            if (!textarea) return; // Element not on page

            // CLEANUP: Destroy existing instances on this element to prevent "ghosts"
            if (window.FroalaEditor.instances) {
                Array.from(window.FroalaEditor.instances).forEach(instance => {
                    if (instance.$el && instance.$el[0].id === this.textareaId) {
                        instance.destroy();
                    }
                });
            }

            // CLEANUP: Remove initialized class if stuck
            if (textarea.classList.contains('fr-initialized')) {
                textarea.classList.remove('fr-initialized');
            }

            // INITIALIZE
            try {
                new FroalaEditor(`#${this.textareaId}`, {
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
                    // Remove 'contentChanged' event to rely solely on the Submit button sync
                    events: {}
                });
                console.log('Froala Initialized');
            } catch (e) {
                console.error("Froala Init Error:", e);
            }
        }
    };

    /**
     * 3. Lifecycle Hooks (The Fix for wire:navigate)
     */

    // A. Initial Load (Hard Refresh)
    FroalaManager.init();

    // B. Navigation Load (wire:navigate)
    // This is the CRITICAL fix. We wait 50ms for the DOM swap to finish.
    document.addEventListener('livewire:navigated', () => {
        setTimeout(() => FroalaManager.init(), 50);
    });

    // C. Re-init after Save (optional, if you feel the editor breaks after save)
    document.addEventListener('settings-saved', () => {
        setTimeout(() => FroalaManager.init(), 100);
    });

</script>
@endscript
