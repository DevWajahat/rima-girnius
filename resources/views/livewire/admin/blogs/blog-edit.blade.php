<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Edit Post</h2>
            <p class="text-muted mb-0">Update your story.</p>
        </div>
        <button type="button" onclick="updateBlog()" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-save me-2"></i> Update Post
        </button>
    </div>

    <div class="row g-4">

        <div class="col-lg-8">

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

            <div class="card border-0 shadow-sm mb-4" wire:ignore>
                <div class="card-body p-0">
                    <div id="editorjs" style="min-height: 500px; padding: 40px;"></div>
                </div>
            </div>
            @error('content') <div class="alert alert-danger">{{ $message }}</div> @enderror

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-search me-2 text-muted"></i> Search Engine Optimization</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" class="form-control" wire:model="meta_title">
                        @error('meta_title') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea class="form-control" rows="3" wire:model="meta_description"></textarea>
                        @error('meta_description') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keywords</label>
                        <input type="text" class="form-control" wire:model="meta_keyword">
                        @error('meta_keyword') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">Featured Image</h6>
                </div>
                <div class="card-body text-center p-4">
                    @if ($new_image)
                        <img src="{{ $new_image->temporaryUrl() }}" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 200px;">
                    @elseif($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 200px;">
                    @else
                        <div class="bg-light rounded p-4 mb-3 border border-dashed">
                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                            <p class="small text-muted mb-0">No image selected</p>
                        </div>
                    @endif

                    <input type="file" id="featImg" class="d-none" wire:model="new_image">
                    <label for="featImg" class="btn btn-outline-primary btn-sm w-100">
                        <i class="fas fa-upload me-1"></i> {{ $post->image ? 'Change Image' : 'Upload Image' }}
                    </label>
                    @error('new_image') <span class="text-danger small d-block mt-2">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">Tags</h6>
                </div>
                <div class="card-body p-4">
                    <label class="form-label small text-muted">Comma separated tags</label>
                    <input type="text" class="form-control" wire:model="tags">
                    @error('tags') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-4">
                    <h5 class="card-title text-white"><i class="fas fa-info-circle me-2"></i> Editing Mode</h5>
                    <p class="card-text small opacity-75">
                        You are currently editing an existing post. Changes will reflect immediately after saving.
                    </p>
                </div>
            </div>

        </div>
    </div>

</div>

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
    <script src="https://cdn.jsdelivr.net/npm/editorjs-undo/dist/bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/editorjs-text-alignment-blocktune@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/attaches@latest"></script>
@endassets

@script
<script>
    let editor;

    function initEditor() {
        if (editor) return;

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
            underline: Underline,
        };

        let initialData = @json($content);

        try {
            if (typeof initialData === 'string') {
                initialData = JSON.parse(initialData);
            }
        } catch (e) {
            console.error('Error parsing JSON content', e);
            initialData = {};
        }

        editor = new EditorJS({
            holder: 'editorjs',
            placeholder: 'Click here to start writing your story...',
            data: initialData,

            tools: {
                ...commonTools,
                columns: {
                    class: editorjsColumns,
                    config: { tools: commonTools }
                },
            },

            onReady: () => {
                if (typeof EditorjsDragDrop !== 'undefined') new EditorjsDragDrop(editor);
                if (typeof Undo !== 'undefined') new Undo({ editor });
            },
        });
    }

    initEditor();

    window.updateBlog = () => {
        editor.save().then((outputData) => {
            const jsonString = JSON.stringify(outputData);
            $wire.update(jsonString);
        }).catch((error) => {
            console.error('Saving failed: ', error);
        });
    };
</script>
@endscript
