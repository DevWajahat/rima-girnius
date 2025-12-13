<div>
    {{-- CSS links kept minimal --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        /* Styles to keep the view clean and centered */
        #featured-book-section-cms .card { margin-left: auto; margin-right: auto; max-width: 100%; }
        .content-body .row { margin-left: 0; margin-right: 0; padding: 0; }
        #featured-book-section-cms { overflow-x: hidden; }
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
        }
    </style>

    <section class="mt-5 mb-5 my-5" id="featured-book-section-cms">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Featured Book Section Content</h4>
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
                        <form class="form form-vertical mt-5 mb-5 my-5" wire:submit.prevent="saveFeaturedBookSection">
                            <div class="row">

                                {{-- 1. Book Title Input --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label d-flex align-items-center">
                                            <i class="fas fa-book-reader me-2"></i> Book Title (H2/H3)
                                        </label>
                                        <input type="text" class="form-control" placeholder="The compelling title of the featured book..." wire:model.defer="bookTitle">
                                        @error('bookTitle') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <hr class="my-2">

                                {{-- 2. Book Image Upload --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label d-flex align-items-center" for="bookImage">
                                            <i class="fas fa-image me-2"></i> Book Cover Image (JPG, PNG, max 2MB)
                                            @if ($existingBookImage)
                                                <small class="ms-2 text-muted">(Current Image set)</small>
                                            @endif
                                        </label>
                                        <input type="file" id="bookImage" class="form-control" wire:model="bookImage">
                                        <small class="form-text text-muted">Upload a new image to replace the current one.</small>
                                        @error('bookImage') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                {{-- Image Preview/Existing Image Display --}}
                                <div class="col-12 mb-3">
                                    @if ($bookImage)
                                        <p class="text-info mt-2"><i class="fas fa-spinner fa-spin me-2"></i> New Image Preview:</p>
                                        <div class="img-preview-container">
                                            <img src="{{ $bookImage->temporaryUrl() }}" class="img-preview" alt="New Image Preview">
                                        </div>
                                    @elseif ($existingBookImage)
                                        <p class="text-info mt-2"><i class="fas fa-eye me-2"></i> Current Image:</p>
                                        <div class="img-preview-container">
                                            <img src="{{ asset('storage/' . $existingBookImage) }}" class="img-preview" alt="Current Image">
                                        </div>
                                    @endif
                                </div>

                                <hr class="my-2">

                                {{-- 3. Book Description Textarea --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label d-flex align-items-center">
                                            <i class="fas fa-pencil-alt me-2"></i> Long Description Text
                                        </label>
                                        <textarea class="form-control" rows="6" placeholder="A comprehensive summary or description of the featured book..." wire:model.defer="bookDescription"></textarea>
                                        @error('bookDescription') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>


                                {{-- Save Button --}}
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-float waves-light me-1" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Save Book Section</span>
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
