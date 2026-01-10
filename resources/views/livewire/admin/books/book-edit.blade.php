<div class="container-fluid p-4">

    <form wire:submit.prevent="update">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Edit Book</h2>
                <p class="text-muted mb-0">Updating: <span class="fw-bold">{{ $title }}</span></p>
            </div>

            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                <span wire:loading.remove><i class="fas fa-save me-2"></i> Update Book</span>
                <span wire:loading><i class="fas fa-spinner fa-spin me-2"></i> Updating...</span>
            </button>
        </div>

        <div class="row g-4">

            {{-- LEFT COLUMN --}}
            <div class="col-lg-8">

                {{-- Basic Info --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Book Title</label>
                            <input type="text" class="form-control form-control-lg" wire:model="title">
                            @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea class="form-control" rows="5" wire:model="description"></textarea>
                            @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Pricing --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3"><h6 class="mb-0 fw-bold">Pricing ($)</h6></div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Regular Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" wire:model="price">
                                @error('price') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Sale Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" wire:model="sale_price">
                                @error('sale_price') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN --}}
            <div class="col-lg-4">

                {{-- Status --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="publishSwitch" wire:model="is_published">
                            <label class="form-check-label fw-bold" for="publishSwitch">Publish Immediately</label>
                        </div>
                    </div>
                </div>

                {{-- Main Cover --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3"><h6 class="mb-0 fw-bold">Main Cover</h6></div>
                    <div class="card-body text-center p-4">
                        {{-- Show New Preview if Uploaded, otherwise Show Old --}}
                        @if ($new_cover_image)
                            <p class="small text-success fw-bold">New Image Selected:</p>
                            <img src="{{ $new_cover_image->temporaryUrl() }}" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 200px;">
                        @elseif ($old_cover_image)
                            <p class="small text-muted">Current Cover:</p>
                            <img src="{{ asset('storage/'.$old_cover_image) }}" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 200px;">
                        @else
                            <div class="bg-light rounded p-4 mb-3 border border-dashed text-muted">
                                <i class="fas fa-image fa-2x mb-2"></i><br>No Cover
                            </div>
                        @endif

                        <input type="file" id="coverImg" class="d-none" wire:model="new_cover_image">
                        <label for="coverImg" class="btn btn-outline-primary btn-sm w-100">Change Cover</label>
                        @error('new_cover_image') <span class="text-danger small d-block mt-2">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Gallery Images --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3"><h6 class="mb-0 fw-bold">Gallery Images</h6></div>
                    <div class="card-body p-4">

                        {{-- 1. Existing Images (Saved in DB) --}}
                        @if(count($existing_gallery_images) > 0)
                            <label class="small text-muted fw-bold mb-2">Current Gallery</label>
                            <div class="row g-2 mb-3">
                                @foreach($existing_gallery_images as $img)
                                    <div class="col-4 position-relative" wire:key="existing-img-{{ $img->id }}">
                                        <img src="{{ asset('storage/'.$img->image) }}" class="img-fluid rounded shadow-sm border w-100" style="aspect-ratio: 1/1; object-fit: cover;">
                                        {{-- Delete DB Image --}}
                                        <button type="button"
                                                wire:click="deleteExistingImage({{ $img->id }})"
                                                wire:confirm="Remove this image permanently?"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle p-0 d-flex align-items-center justify-content-center shadow-sm"
                                                style="width: 24px; height: 24px;">
                                            <i class="fas fa-trash-alt" style="font-size: 10px;"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- 2. New Pending Images (Not Saved Yet) --}}
                        @if(count($pending_gallery_images) > 0)
                            <label class="small text-success fw-bold mb-2">New Additions (Pending)</label>
                            <div class="row g-2 mb-3">
                                @foreach($pending_gallery_images as $index => $img)
                                    <div class="col-4 position-relative" wire:key="pending-img-{{ $index }}">
                                        <img src="{{ $img->temporaryUrl() }}" class="img-fluid rounded shadow-sm border w-100" style="aspect-ratio: 1/1; object-fit: cover;">
                                        {{-- Remove from Pending --}}
                                        <button type="button"
                                                wire:click="removePendingImage({{ $index }})"
                                                class="btn btn-secondary btn-sm position-absolute top-0 end-0 m-1 rounded-circle p-0 d-flex align-items-center justify-content-center shadow-sm"
                                                style="width: 24px; height: 24px;">
                                            <i class="fas fa-times" style="font-size: 10px;"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Input --}}
                        <input type="file" id="galleryInput-{{ $this->getId() }}"
                               class="d-none"
                               wire:model="temp_gallery_input"
                               multiple>
                        <label for="galleryInput-{{ $this->getId() }}" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="fas fa-plus me-1"></i> Add Images
                        </label>
                        <div wire:loading wire:target="temp_gallery_input" class="text-center mt-2 small text-muted">
                            <i class="fas fa-spinner fa-spin me-1"></i> Processing...
                        </div>
                    </div>
                </div>

                {{-- PDF Upload --}}
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-header bg-transparent py-3"><h6 class="mb-0 fw-bold">Digital File (PDF)</h6></div>
                    <div class="card-body p-4 text-center">
                        @if ($new_pdf_file)
                            <div class="alert alert-success small mb-2"><i class="fas fa-file-pdf me-1"></i> New File Selected</div>
                        @elseif ($old_pdf_file)
                             <div class="alert alert-secondary small mb-2"><i class="fas fa-check-circle me-1"></i> File Exists</div>
                        @endif

                        <input type="file" id="pdfFile" class="d-none" wire:model="new_pdf_file" accept=".pdf">
                        <label for="pdfFile" class="btn btn-dark btn-sm w-100"><i class="fas fa-file-upload me-2"></i> Replace PDF</label>
                        @error('new_pdf_file') <span class="text-danger small d-block mt-2">{{ $message }}</span> @enderror
                    </div>
                </div>

            </div>
        </div>

    </form>
</div>
