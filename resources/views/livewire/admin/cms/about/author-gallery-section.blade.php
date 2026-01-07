<div>
    {{-- Custom Styles for Gallery Grid --}}
    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1.5rem;
        }
        .gallery-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            aspect-ratio: 1; /* Square images */
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            transition: transform 0.2s;
        }
        .gallery-item:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 15px rgba(0,0,0,0.15);
        }
        .gallery-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .btn-remove {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 255, 255, 0.9);
            color: #ea5455;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            z-index: 10;
        }
        .btn-remove:hover {
            background: #ea5455;
            color: white;
        }
        /* Upload Box Styling */
        .upload-zone {
            border: 2px dashed #7367f0;
            background: rgba(115, 103, 240, 0.05);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: background 0.3s;
        }
        .upload-zone:hover {
            background: rgba(115, 103, 240, 0.1);
        }
    </style>

    {{-- Breadcrumbs --}}
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Author Gallery</h2>
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

    {{-- Main Content --}}
    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">Manage Gallery Images</h4>
        </div>

        <div class="card-body p-4">
            @session('message')
                <div class="alert alert-success p-2 mb-3"><i class="fas fa-check me-2"></i>{{ $value }}</div>
            @endsession

            <form wire:submit="save">

                {{-- 1. Section Heading --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Gallery Section Title</label>
                    {{-- Fixed: wire:model matches property "authorHeading" --}}
                    <input type="text" class="form-control form-control-lg" wire:model="authorHeading" placeholder="e.g. Moments & Memories">
                    @error('authorHeading') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <hr class="my-4">

                {{-- 2. Existing Gallery Grid --}}
                <h5 class="fw-bold mb-3 text-primary"><i class="fas fa-images me-2"></i>Current Gallery</h5>

                {{-- Fixed: Iterating over "galleryImages" --}}
                @if(count($galleryImages) > 0)
                    <div class="gallery-grid mb-4">
                        @foreach($galleryImages as $index => $path)
                            <div class="gallery-item" wire:key="img-{{ $index }}">
                                <img src="{{ asset('storage/' . $path) }}" class="gallery-img" alt="Gallery Image">
                                <button type="button" class="btn-remove shadow-sm"
                                        wire:click="removeImage({{ $index }})"
                                        title="Remove Image">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-light text-center mb-4" role="alert">
                        No images in the gallery yet. Add some below!
                    </div>
                @endif

                {{-- 3. New Uploads Preview & Input --}}
                <h5 class="fw-bold mb-3 text-success"><i class="fas fa-plus-circle me-2"></i>Add New Photos</h5>

                {{-- Preview of "To Be Uploaded" --}}
                @if($newImages)
                    <div class="gallery-grid mb-3">
                        @foreach($newImages as $index => $img)
                            <div class="gallery-item border-success" wire:key="new-{{ $index }}">
                                <img src="{{ $img->temporaryUrl() }}" class="gallery-img">
                                <button type="button" class="btn-remove bg-success text-white"
                                        wire:click="removeNewImage({{ $index }})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Upload Input Zone --}}
                <div class="mb-4">
                    <label class="upload-zone w-100" for="gallery-upload">
                        <div class="mb-2">
                            <i class="fas fa-cloud-upload-alt fa-3x text-primary"></i>
                        </div>
                        <h5 class="mb-1">Click here to Select Photos</h5>
                        <p class="text-muted small">Select multiple files to upload at once.</p>
                        <input type="file" id="gallery-upload" hidden wire:model="newImages" multiple accept="image/*">
                    </label>
                    @error('newImages.*') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Save Button --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <span wire:loading.remove><i class="fas fa-save me-2"></i> Save Gallery</span>
                        <span wire:loading><i class="fas fa-spinner fa-spin me-2"></i> Uploading & Saving...</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
