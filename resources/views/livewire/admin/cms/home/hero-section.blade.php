<div>
    {{-- CSS links kept minimal --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        /* [CSS styles from before remain unchanged] */
        #hero-section-cms .card { margin-left: auto; margin-right: auto; max-width: 100%; }
        .content-body .row { margin-left: 0; margin-right: 0; padding: 0; }
        #hero-section-cms { overflow-x: hidden; }
        .input-group-text { width: 40px; justify-content: center; }

        /* Custom Style for Simple Success Message (Mimicking a nice notification) */
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

    <section class="mt-5 mb-5 my-5" id="hero-section-cms">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Hero Section Content</h4>
                    </div>
                    <div class="card-body">

                        {{-- **REPLACEMENT FOR TOASTR/BOOTSTRAP ALERT** --}}
                        {{-- This uses Livewire 3's native session directive --}}
                        @session('message')
                            <div class="livewire-success-message">
                                <i class="fas fa-check-circle me-2"></i> {{ $value }}
                            </div>
                        @endsession

                        @if (session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- The Livewire Form (unchanged logic) --}}
                        <form class="form form-vertical mt-5 mb-5 my-5" wire:submit.prevent="saveHeroSection">
                            <div class="row">

                                {{-- 1. Title Input --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label d-flex align-items-center">
                                            <i class="fas fa-heading me-2"></i> Heading / Title
                                        </label>
                                        <input type="text" class="form-control" placeholder="Enter the main headline for the Hero Section..." wire:model.defer="heroTitle">
                                        @error('heroTitle') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                {{-- 2. Subtitle Textarea --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label d-flex align-items-center">
                                            <i class="fas fa-paragraph me-2"></i> Subtitle Text
                                        </label>
                                        <textarea class="form-control" rows="3" placeholder="A short, descriptive paragraph beneath the title..." wire:model.defer="heroSubtitle"></textarea>
                                        @error('heroSubtitle') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                {{-- 3. Button Group Design --}}
                                <div class="col-12">
                                    <h5 class="mt-3 mb-2 text-primary d-flex align-items-center"><i class="fas fa-link me-2"></i> Call to Action Button</h5>
                                </div>

                                {{-- Button Text Input --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Button Text</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="far fa-edit"></i></span>
                                            <input type="text" class="form-control" placeholder="e.g., Get Started, View Solutions" wire:model.defer="heroButtonText">
                                        </div>
                                        @error('heroButtonText') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                {{-- Button Link Input --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Button Link (URL)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                            <input type="text" class="form-control" placeholder="e.g., https://yourdomain.com/contact" wire:model.defer="heroButtonLink">
                                        </div>
                                        @error('heroButtonLink') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                {{-- Save Button --}}
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-primary waves-effect waves-float waves-light me-1" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Save Hero Section</span>
                                        <span wire:loading>Saving...</span>
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
