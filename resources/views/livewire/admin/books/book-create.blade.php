<div class="container-fluid p-4">

    {{-- 1. FORM START --}}
    <form wire:submit.prevent="save">

        {{-- Header Section with SAVE BUTTON --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Add New Book</h2>
                <p class="text-muted mb-0">Upload a new digital book product.</p>
            </div>

            {{-- 2. SAVE BUTTON --}}
            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                <span wire:loading.remove><i class="fas fa-save me-2"></i> Save Book</span>
                <span wire:loading><i class="fas fa-spinner fa-spin me-2"></i> Saving...</span>
            </button>
        </div>

        <div class="row g-4">

            {{-- LEFT COLUMN: Main Info --}}
            <div class="col-lg-8">

                {{-- Title & Description --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        {{-- Title --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Book Title</label>
                            <input type="text" class="form-control form-control-lg" wire:model="title" placeholder="e.g. Eureka and the Magical Trio">
                            @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea class="form-control" rows="5" wire:model="description" placeholder="Book summary..."></textarea>
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
                                <input type="number" step="0.01" class="form-control" wire:model="price" placeholder="0.00">
                                @error('price') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Sale Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" wire:model="sale_price" placeholder="0.00">
                                @error('sale_price') <span class="text-danger small">{{ $message }}</span> @enderror
                                <div class="form-text text-muted small">Enter same as Regular Price if no discount.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Settings & Files --}}
            <div class="col-lg-4">

                {{-- Status Switch --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="publishSwitch" wire:model="is_published">
                            <label class="form-check-label fw-bold" for="publishSwitch">Publish Immediately</label>
                        </div>
                    </div>
                </div>

                {{-- Main Cover Image --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3"><h6 class="mb-0 fw-bold">Main Cover</h6></div>
                    <div class="card-body text-center p-4">
                        @if ($cover_image)
                            <img src="{{ $cover_image->temporaryUrl() }}" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 200px;">
                        @else
                            <div class="bg-light rounded p-4 mb-3 border border-dashed text-muted">
                                <i class="fas fa-image fa-2x mb-2"></i><br>No Cover
                            </div>
                        @endif
                        <input type="file" id="coverImg" class="d-none" wire:model="cover_image">
                        <label for="coverImg" class="btn btn-outline-primary btn-sm w-100">Upload Cover</label>
                        @error('cover_image') <span class="text-danger small d-block mt-2">{{ $message }}</span> @enderror
                    </div>
                </div>

{{-- Gallery Images --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3"><h6 class="mb-0 fw-bold">Gallery Images</h6></div>
                    <div class="card-body p-4">

                        {{-- Preview Grid --}}
                        @if (!empty($gallery_images))
                            <div class="row g-2 mb-3">
                                @foreach ($gallery_images as $index => $image)
                                    <div class="col-4 position-relative">
                                        {{-- Image Preview --}}
                                        <img src="{{ $image->temporaryUrl() }}"
                                             class="img-fluid rounded shadow-sm border w-100"
                                             style="aspect-ratio: 1/1; object-fit: cover;">

                                        {{-- Remove Button (X) --}}
                                        <button type="button"
                                                wire:click="removeGalleryImage({{ $index }})"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle p-0 d-flex align-items-center justify-content-center shadow-sm"
                                                style="width: 24px; height: 24px;">
                                            <i class="fas fa-times" style="font-size: 12px;"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-light rounded p-4 mb-3 border border-dashed text-center text-muted">
                                <i class="fas fa-images fa-2x mb-2"></i><br>No Gallery Images
                            </div>
                        @endif

                        {{-- Multiple File Input (Bound to Temporary Property) --}}
                        {{-- ID randomizer ensures input resets properly --}}
                        <input type="file" id="galleryImgs-{{ $this->getId() }}"
                               class="d-none"
                               wire:model="new_gallery_images"
                               multiple>

                        <label for="galleryImgs-{{ $this->getId() }}" class="btn btn-outline-secondary btn-sm w-100">
                            {{-- Show "Add More" if images exist, otherwise "Add Images" --}}
                            <i class="fas fa-plus me-1"></i> {{ count($gallery_images) > 0 ? 'Add More Images' : 'Add Images' }}
                        </label>

                        {{-- Loading Indicator for smoother UX --}}
                        <div wire:loading wire:target="new_gallery_images" class="text-center mt-2 small text-muted">
                            <i class="fas fa-spinner fa-spin me-1"></i> Processing images...
                        </div>

                        @error('gallery_images.*') <span class="text-danger small d-block mt-2">{{ $message }}</span> @enderror
                    </div>
                </div>


                {{-- PDF Upload --}}
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-header bg-transparent py-3"><h6 class="mb-0 fw-bold">Digital File (PDF)</h6></div>
                    <div class="card-body p-4 text-center">
                        @if ($pdf_file)
                            <div class="alert alert-success small mb-2"><i class="fas fa-file-pdf me-1"></i> File Selected</div>
                        @endif
                        <input type="file" id="pdfFile" class="d-none" wire:model="pdf_file" accept=".pdf">
                        <label for="pdfFile" class="btn btn-dark btn-sm w-100"><i class="fas fa-file-upload me-2"></i> Upload PDF</label>
                        @error('pdf_file') <span class="text-danger small d-block mt-2">{{ $message }}</span> @enderror
                        <div class="small text-muted mt-2">Max 10MB</div>
                    </div>
                </div>
            </div>
        </div>

    </form>
    {{-- FORM END --}}

</div>
