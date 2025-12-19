<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Create New Post</h2>
            <p class="text-muted mb-0">Write your story.</p>
        </div>
        {{-- The Save Button calls a JS function first to sync EditorJS data --}}
        <button type="button" onclick="saveBlog()" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-save me-2"></i> Publish Post
        </button>
    </div>

    <div class="row g-4">

        {{-- LEFT COLUMN: Main Content --}}
        <div class="col-lg-8">

            {{-- 1. Title Input --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <label class="form-label fw-bold text-uppercase small text-muted">Blog Title</label>
                    <input type="text" class="form-control form-control-lg border-0 fs-2 fw-bold px-0"
                           placeholder="Enter your headline here..."
                           wire:model.blur="title"
                           style="box-shadow: none; border-bottom: 2px solid #eee !important; border-radius: 0;">
                    @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- 2. EditorJS Area (Your Custom Editor) --}}
            {{-- wire:ignore prevents Livewire from refreshing this div and killing the editor --}}
            <div class="card border-0 shadow-sm mb-4" wire:ignore>
                <div class="card-body p-0">
                    <div id="editorjs" style="min-height: 500px; padding: 40px;"></div>
                </div>
            </div>
            @error('content') <div class="alert alert-danger">{{ $message }}</div> @enderror

            {{-- 3. SEO Settings --}}
            {{-- 3. SEO Settings --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-search me-2 text-muted"></i> Search Engine Optimization</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" class="form-control" wire:model="meta_title" placeholder="Best title for Google search results">
                        @error('meta_title')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea class="form-control" rows="3" wire:model="meta_description" placeholder="A short summary of your post..."></textarea>
                        @error('meta_description')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keywords</label>
                        <input type="text" class="form-control" wire:model="meta_keyword" placeholder="blog, technology, news">
                        @error('meta_keyword')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>



        </div>

        {{-- RIGHT COLUMN: Sidebar Settings --}}
        <div class="col-lg-4">

            {{-- 1. Featured Image --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">Featured Image</h6>
                </div>
                <div class="card-body text-center p-4">
                    @if ($featured_image)
                        <img src="{{ $featured_image->temporaryUrl() }}" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 200px;">
                    @else
                        <div class="bg-light rounded p-4 mb-3 border border-dashed">
                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                            <p class="small text-muted mb-0">No image selected</p>
                        </div>
                    @endif

                    <input type="file" id="featImg" class="d-none" wire:model="featured_image">
                    <label for="featImg" class="btn btn-outline-primary btn-sm w-100">
                        <i class="fas fa-upload me-1"></i> Upload Image
                    </label>
                    @error('featured_image') <span class="text-danger small d-block mt-2">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- 2. Tags --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">Tags</h6>
                </div>
                <div class="card-body p-4">
                    <label class="form-label small text-muted">Comma separated tags</label>
                    <input type="text" class="form-control" wire:model="tags" placeholder="e.g. Health, Coding, Life">
                    @error('tags')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- 3. Info Card --}}
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-4">
                    <h5 class="card-title text-white"><i class="fas fa-info-circle me-2"></i> Writing Tip</h5>
                    <p class="card-text small opacity-75">
                        Use the <strong>Tab</strong> key in the editor to open the tool menu quickly. You can drag and drop blocks to rearrange them.
                    </p>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- EDITOR JS SCRIPTS & CONFIGURATION --}}
@assets
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/paragraph@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/simple-image@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/image@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/link@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/table@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/code@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/inline-code@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/marker@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/warning@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/underline@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@calumk/editorjs-columns@latest"></script>
   <script src="https://cdn.jsdelivr.net/npm/editorjs-drag-drop/dist/bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/editorjs-undo/dist/bundle.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/editorjs-text-alignment-blocktune@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/attaches@latest"></script>
@endassets

@script
<script>
    let editor;

    function initEditor() {
        if (editor) return;

        // 1. Base64 Uploader (Restored)
        const base64Uploader = {
            uploadByFile(file) {
                return new Promise((resolve) => {
                    const reader = new FileReader();
                    reader.onload = () => {
                        resolve({ success: 1, file: { url: reader.result } });
                    };
                    reader.readAsDataURL(file);
                });
            },
            uploadByUrl(url) {
                return new Promise((resolve) => {
                    resolve({ success: 1, file: { url: url } });
                });
            }
        };

        // 2. Full Tools Configuration (Restored all your tools)
        // We define alignTune here so 'columns' can access it.
        const commonTools = {
            alignTune: {
                class: AlignmentBlockTune,
                config: { default: "left" }
            },
            header: {
                class: Header,
                inlineToolbar: true,
                tunes: ['alignTune']
            },
            paragraph: {
                class: Paragraph,
                inlineToolbar: true,
                tunes: ['alignTune']
            },
            list: {
                class: EditorjsList,
                inlineToolbar: true,
                tunes: ['alignTune']
            },
            checklist: { class: Checklist, inlineToolbar: true },
            quote: {
                class: Quote,
                inlineToolbar: true,
                config: { quotePlaceholder: 'Enter a quote', captionPlaceholder: 'Author' }
            },
            image: {
                class: ImageTool,
                config: { uploader: base64Uploader }
            },
            attaches: {
                class: AttachesTool,
                config: { uploader: base64Uploader }
            },
            embed: { class: Embed, inlineToolbar: true },
            table: {
                class: Table,
                inlineToolbar: true,
                config: { rows: 2, cols: 3 }
            },
            code: CodeTool,
            marker: Marker,
            delimiter: Delimiter,
            warning: Warning,
            underline: Underline, // Ensure Underline is included if imported
        };

        editor = new EditorJS({
            holder: 'editorjs',
            placeholder: 'Click here to start writing your story...',

            // 3. Connect Tools
            tools: {
                ...commonTools,
                columns: {
                    class: editorjsColumns,
                    config: { tools: commonTools }
                },
            },

            // 4. Safe Plugin Initialization
            onReady: () => {
                if (typeof EditorjsDragDrop !== 'undefined') new EditorjsDragDrop(editor);
                if (typeof Undo !== 'undefined') new Undo({ editor });
            },
        });
    }

    initEditor();

    // 5. The FIXED Save Function
    window.saveBlog = () => {
        editor.save().then((outputData) => {

            // Step A: Convert the object to a String
            // This prevents the "toJSON" crash
            const jsonString = JSON.stringify(outputData);

            // Step B: Send to Livewire
            // This allows the server to process validation
            // and return the error messages to the UI.
            $wire.save(jsonString);

        }).catch((error) => {
            console.error('Saving failed: ', error);
        });
    };
</script>
@endscript
