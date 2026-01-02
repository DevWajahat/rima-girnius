<div>
    {{-- Internal CSS for Gallery Thumbnails --}}
    <style>
        .gallery-item {
            position: relative;
            height: 150px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
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
            background: #28c76f; /* Green */
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>

    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">Manage Gallery Images</h4>
        </div>

        <div class="card-body p-4">
            @session('message') <div class="alert alert-success p-2 mb-3"><i class="fas fa-check"></i> {{ $value }}</div> @endsession
            @session('error') <div class="alert alert-danger p-2 mb-3"><i class="fas fa-exclamation"></i> {{ $value }}</div> @endsession

            <form wire:submit="saveGallerySection">

                {{-- 1. Gallery Heading --}}
                <div class="mb-4">
                    <label class="form-label fw-bold fs-5">Section Heading</label>
                    <input type="text" class="form-control fs-5" placeholder="e.g. Moments & Memories" wire:model="galleryHeading">
                    @error('galleryHeading') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- 2. Image Upload Input --}}
                <div class="mb-4 p-4 border border-dashed rounded bg-light text-center">
                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                    <h5>Drop images here or click to upload</h5>
                    <p class="text-muted small">Allowed: JPG, PNG, WEBP. Max 5MB per image.</p>

                    <label class="btn btn-primary mt-2">
                        Browse Files
                        {{-- Added 'multiple' explicitly --}}
                        <input type="file" hidden wire:model="newGalleryImages" multiple accept="image/*">
                    </label>

                    {{-- SCOPED LOADING: Only shows when 'newGalleryImages' is processing --}}
                    <div wire:loading wire:target="newGalleryImages" class="d-block mt-2 text-primary fw-bold">
                        Uploading... <i class="fas fa-spinner fa-spin"></i>
                    </div>

                    {{-- General Validation Errors --}}
                    @error('newGalleryImages') <span class="text-danger d-block mt-2 small">{{ $message }}</span> @enderror
                    {{-- Specific File Errors --}}
                    @error('newGalleryImages.*') <span class="text-danger d-block mt-2 small">{{ $message }}</span> @enderror
                </div>

                {{-- 3. Gallery Grid --}}
                <label class="form-label fw-bold mb-3">Gallery Preview</label>

                <div class="row g-3">
                    {{-- Loop Existing Images --}}
                    @if(is_array($existingGalleryImages))
                        @foreach($existingGalleryImages as $index => $img)
                            {{-- ADDED WIRE:KEY to prevent UI glitching --}}
                            <div class="col-6 col-md-4 col-lg-3" wire:key="existing-{{ $index }}">
                                <div class="gallery-item">
                                    <img src="{{ asset('storage/'.$img) }}" class="gallery-img">
                                    <button type="button" class="btn-remove-img" wire:click="removeImage({{ $index }})" title="Delete Image">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- Loop Newly Uploaded Images --}}
                    @if($newGalleryImages)
                        @foreach($newGalleryImages as $index => $img)
                            {{-- ADDED WIRE:KEY --}}
                            <div class="col-6 col-md-4 col-lg-3" wire:key="new-{{ $index }}">
                                <div class="gallery-item" style="border-color: #28c76f;">
                                    {{-- Safely check if temporaryUrl exists to prevent crashes on failed uploads --}}
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

                    @if(empty($existingGalleryImages) && empty($newGalleryImages))
                        <div class="col-12 text-center text-muted py-5">
                            No images in gallery yet. Upload some above!
                        </div>
                    @endif
                </div>

                <div class="text-end mt-5">
                    {{-- Disable button while uploading OR saving --}}
                    <button type="submit" class="btn btn-primary px-5 btn-lg" wire:loading.attr="disabled">
                        <span wire:loading.remove>Save Gallery</span>
                        <span wire:loading>Saving...</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
