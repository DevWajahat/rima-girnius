<div>
    <style>
        /* Visual cue for the Category input to make it look "small" like the frontend */
        .input-category {
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            font-weight: 600;
            color: #6e6b7b;
        }
        /* Visual cue for the Title to look "Big" */
        .input-title {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .preview-container {
            background: #f8f8f8;
            border: 2px dashed #ddd;
            border-radius: 8px;
            text-align: center;
            padding: 20px;
            min-height: 400px; /* Kept height but added breathing room around image */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .preview-image {
            max-width: 90%; /* Reduced from 100% to prevent touching edges */
            max-height: 320px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            object-fit: cover;
        }
    </style>

    <div class="content-header row">
        <div class="content-header-left col-md-9 px-5 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Hero Section</h2>
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

    <div class="card">
        <div class="card-header px-5 border-bottom">
            <h4 class="card-title">Edit Hero Area</h4>
            <div class="card-subtitle text-muted">Update the main visual area of your homepage.</div>
        </div>

        <div class="card-body p-4">

            @session('message')
                <div class="alert alert-success p-2 mb-3"><i class="fas fa-check"></i> {{ $value }}</div>
            @endsession
            @session('error')
                 <div class="alert alert-danger p-2 mb-3"><i class="fas fa-exclamation"></i> {{ $value }}</div>
            @endsession

            <form wire:submit="save">
                <div class="row g-5">

                    <div class="col-md-5">
                        <label class="form-label fw-bold mb-2">Book Cover Image</label>

                        <div class="preview-container mb-3">
                            @if ($heroBookImage)
                                <img src="{{ $heroBookImage->temporaryUrl() }}" class="preview-image rounded">
                                <span class="badge bg-primary mt-3">New Image Selected</span>
                            @elseif($existingHeroBookImage)
                                <img src="{{ asset('storage/' . $existingHeroBookImage) }}" class="preview-image rounded">
                                <span class="badge bg-secondary mt-3">Current Image</span>
                            @else
                                <div class="text-muted p-3">
                                    <i class="fas fa-image fa-3x mb-2"></i>
                                    <p>No image uploaded yet.</p>
                                </div>
                            @endif
                        </div>

                        <div class="d-grid px-3">
                            <input type="file" id="uploadImage" class="form-control" wire:model="heroBookImage" accept="image/*">
                            @error('heroBookImage') <span class="text-danger small">{{ $message }}</span> @enderror
                            <div class="form-text text-center mt-2">Recommended size: Portrait (e.g., 600x900px)</div>
                            <div wire:loading wire:target="heroBookImage" class="text-primary text-center mt-1">
                                <small>Uploading...</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 d-flex flex-column justify-content-center">
                        <div class="p-4 border rounded bg-white shadow-sm">

                            <div class="mb-4">
                                <label class="form-label text-uppercase small text-muted">Category Tag</label>
                                <input type="text" class="form-control input-category" placeholder="add Category" wire:model="heroCategory">
                                @error('heroCategory') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Main Heading</label>
                                <input type="text" class="form-control input-title" placeholder="add title" wire:model="heroTitle">
                                @error('heroTitle') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Description Paragraph</label>
                                <textarea class="form-control" rows="5" placeholder="Enter the short book summary here..." wire:model="heroDescription"></textarea>
                                @error('heroDescription') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <hr class="my-4">

                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label fw-bold">Button Text</label>
                                    <input type="text" class="form-control" placeholder="add button text" wire:model="heroButtonText">
                                    @error('heroButtonText') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label fw-bold">Button Link</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-link"></i></span>
                                        <input type="text" class="form-control" placeholder="add link" wire:model="heroButtonLink">
                                    </div>
                                    @error('heroButtonLink') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary btn-lg waves-effect waves-float waves-light px-4">
                                <span wire:loading.remove>Save Changes</span>
                                <span wire:loading><i class="fas fa-spinner fa-spin"></i> Saving...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
