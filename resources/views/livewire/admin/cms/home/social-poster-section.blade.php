<div>
    <style>
        .gallery-item {
            position: relative;
            height: 250px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            cursor: grab;
        }
        .gallery-item:active {
            cursor: grabbing;
        }
        .gallery-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .gallery-item:hover .gallery-img {
            transform: scale(1.05);
        }
        .btn-remove-img {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            border-radius: 4px;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
        }
        .btn-remove-img:hover {
            background: red;
        }
        .new-badge {
            position: absolute;
            bottom: 5px;
            left: 5px;
            background: #28c76f;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .sortable-ghost {
            opacity: 0.4;
        }
    </style>

    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">Manage Social Posters</h4>
        </div>

        <div class="card-body p-4">
            @session('message') <div class="alert alert-success p-2 mb-3"><i class="fas fa-check"></i> {{ $value }}</div> @endsession
            @session('error') <div class="alert alert-danger p-2 mb-3"><i class="fas fa-exclamation"></i> {{ $value }}</div> @endsession

            <form wire:submit="saveSection">

                <div class="mb-4">
                    <label class="form-label fw-bold fs-5">Section Heading</label>
                    <input type="text" class="form-control fs-5" placeholder="e.g. From The World Of Eureka" wire:model="posterHeading">
                    @error('posterHeading') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4 p-4 border border-dashed rounded bg-light text-center">
                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                    <h5>Drop images here or click to upload</h5>
                    <p class="text-muted small">Allowed: JPG, PNG, WEBP. Max 10MB per image.</p>

                    <label class="btn btn-primary mt-2">
                        Browse Files
                        <input type="file" hidden wire:model="newPosters" multiple accept="image/*">
                    </label>

                    <div wire:loading wire:target="newPosters" class="d-block mt-2 text-primary fw-bold">
                        Uploading... <i class="fas fa-spinner fa-spin"></i>
                    </div>

                    @error('newPosters') <span class="text-danger d-block mt-2 small">{{ $message }}</span> @enderror
                    @error('newPosters.*') <span class="text-danger d-block mt-2 small">{{ $message }}</span> @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-label fw-bold mb-0">Posters Order & Preview</label>
                    <small class="text-muted">Drag and drop to reorder images. Click save when done.</small>
                </div>

                <div class="row g-3" x-data="{
                    initSortable() {
                        if(typeof Sortable !== 'undefined') {
                            new Sortable(this.$refs.sortableList, {
                                animation: 150,
                                ghostClass: 'sortable-ghost',
                                onEnd: (evt) => {
                                    let newOrder = Array.from(this.$refs.sortableList.children).map(item => item.dataset.path);
                                    $wire.updateOrder(newOrder);
                                }
                            });
                        }
                    }
                }" x-init="initSortable" x-ref="sortableList">

                    @if(is_array($existingPosters))
                        @foreach($existingPosters as $index => $img)
                            <div class="col-6 col-md-4 col-lg-3" data-path="{{ $img }}" wire:key="existing-{{ $index }}-{{ time() }}">
                                <div class="gallery-item">
                                    <img src="{{ asset('storage/'.$img) }}" class="gallery-img">
                                    <button type="button" class="btn-remove-img" wire:click="removeImage({{ $index }})" title="Delete Image">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="row g-3 mt-2">
                    @if($newPosters)
                        <div class="col-12 mt-4 mb-2"><strong class="text-success">Newly Uploaded (Will be added to the end)</strong></div>
                        @foreach($newPosters as $index => $img)
                            <div class="col-6 col-md-4 col-lg-3" wire:key="new-{{ $index }}">
                                <div class="gallery-item" style="border-color: #28c76f;">
                                    @if(method_exists($img, 'temporaryUrl'))
                                        <img src="{{ $img->temporaryUrl() }}" class="gallery-img">
                                    @endif
                                    <span class="new-badge">NEW</span>
                                    <button type="button" class="btn-remove-img" wire:click="removeNewImage({{ $index }})" title="Remove Upload">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if(empty($existingPosters) && empty($newPosters))
                        <div class="col-12 text-center text-muted py-5">
                            No posters in gallery yet. Upload some above!
                        </div>
                    @endif
                </div>

                <div class="text-end mt-5">
                    <button type="submit" class="btn btn-primary px-5 btn-lg" wire:loading.attr="disabled">
                        <span wire:loading.remove>Save Posters</span>
                        <span wire:loading>Saving...</span>
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</div>
