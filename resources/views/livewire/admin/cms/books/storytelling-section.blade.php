<div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        #storytelling-section-cms .card { margin-left: auto; margin-right: auto; max-width: 100%; }
        .content-body .row { margin-left: 0; margin-right: 0; padding: 0; }
        #storytelling-section-cms { overflow-x: hidden; }

        .livewire-success-message {
            padding: 10px 15px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            color: #155724;
            background-color: #d4edda;
            font-weight: 600;
        }
    </style>

    <section class="mt-5 mb-5 my-5" id="storytelling-section-cms">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Books Page: Storytelling Section</h4>
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

                        <form class="form form-vertical mt-5 mb-5 my-5">
                            <div class="row">

                                {{-- 1. Section Heading --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label d-flex align-items-center">
                                            <i class="fas fa-heading me-2"></i> Section Heading
                                        </label>
                                        <input type="text" class="form-control" placeholder="e.g. The Art of Storytelling" wire:model.defer="sectionHeading">
                                        @error('sectionHeading') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <hr class="my-2">

                                {{-- 2. Storytelling Content (Froala) --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label d-flex align-items-center">
                                            <i class="fas fa-book-open me-2"></i> Story Content (Long Paragraph)
                                        </label>

                                        {{-- wire:ignore is crucial --}}
                                        <div wire:ignore wire:key="froala-story-container">
                                            <textarea id="froala-storytelling-content" class="form-control" rows="10">{{ $initialContent }}</textarea>
                                        </div>

                                        @error('storytellingContent') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                {{-- Save Button --}}
                                <div class="col-12 mt-3">
                                    <button type="button"
                                            class="btn btn-primary waves-effect waves-float waves-light me-1"
                                            wire:loading.attr="disabled"
                                            onclick="syncAndSubmit()">
                                            <span wire:loading.remove>Save Storytelling Section</span>
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
     * 1. GLOBAL FUNCTION: Atomic Save
     */
    window.syncAndSubmit = () => {
        const Froala = window.FroalaEditor;
        const textareaId = 'froala-storytelling-content';
        const textarea = document.getElementById(textareaId);
        let contentToSave = '';

        if (typeof Froala !== 'undefined' && Froala.instances) {
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

        @this.saveStorytellingSection(contentToSave);
    };

    /**
     * 2. LOGIC CONTROLLER
     */
    const StoryEditor = {
        textareaId: 'froala-storytelling-content',

        init: function() {
            // Check if library is loaded
            if (typeof window.FroalaEditor === 'undefined') {
                setTimeout(() => this.init(), 100);
                return;
            }

            const textarea = document.getElementById(this.textareaId);
            if (!textarea) return;

            // CLEANUP: Destroy existing instances (fix for ghosting)
            if (window.FroalaEditor.instances) {
                Array.from(window.FroalaEditor.instances).forEach(instance => {
                    if (instance.$el && instance.$el[0].id === this.textareaId) {
                        instance.destroy();
                    }
                });
            }

            // CLEANUP: DOM classes
            if (textarea.classList.contains('fr-initialized')) {
                textarea.classList.remove('fr-initialized');
            }

            // INITIALIZE
            try {
                new FroalaEditor(`#${this.textareaId}`, {
                    toolbarButtons: {
                        'moreText': {
                            'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'textColor', 'clearFormatting'],
                            'buttonsVisible': 4
                        },
                        'moreParagraph': {
                            'buttons': ['alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'lineHeight', 'outdent', 'indent', 'quote'],
                            'buttonsVisible': 4
                        },
                        'moreRich': {
                            'buttons': ['insertLink', 'insertImage', 'insertTable', 'emoticons', 'html'],
                            'buttonsVisible': 3
                        },
                        'moreMisc': {
                            'buttons': ['undo', 'redo', 'fullscreen', 'spellChecker', 'selectAll', 'help'],
                            'buttonsVisible': 2
                        }
                    },
                    heightMin: 300,
                    events: {} // No auto-sync events, we use button click
                });
            } catch (e) {
                console.error("Froala Init Error:", e);
            }
        }
    };

    /**
     * 3. LIFECYCLE HOOKS (The Fix)
     */

    // A. Initial Page Load
    StoryEditor.init();

    // B. Navigation (wire:navigate) - Wait 50ms for DOM swap
    document.addEventListener('livewire:navigated', () => {
        setTimeout(() => StoryEditor.init(), 50);
    });

    // C. After Save
    document.addEventListener('settings-saved', () => {
        setTimeout(() => StoryEditor.init(), 100);
    });

</script>
@endscript
