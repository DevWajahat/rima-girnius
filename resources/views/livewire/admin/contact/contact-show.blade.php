<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Read Message</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}" wire:navigate class="text-decoration-none">Contacts</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Message #{{ $contact->id }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.contacts.index') }}" wire:navigate class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <button wire:click="delete" wire:confirm="Are you sure you want to delete this message?" class="btn btn-danger text-white">
                <i class="fas fa-trash-alt me-1"></i> Delete
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold">{{ $contact->subject }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                                    <img src="https://ui-avatars.com/api/?name={{$contact->name}}" class="rounded-circle" >
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $contact->name }}</h6>
                                    <span class="text-muted small">{{ $contact->email }}</span>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-light text-secondary border">{{ $contact->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="message-content">
                        <label class="text-uppercase text-secondary small fw-bold mb-2">Message Body</label>
                        <div class="bg-light p-4 rounded border">
                            <p class="mb-0 text-dark" style="white-space: pre-line; line-height: 1.6;">
                                {{ $contact->message }}
                            </p>
                        </div>
                    </div>

                    @if($contact->phone)
                    <div class="mt-4">
                        <label class="text-uppercase text-secondary small fw-bold mb-1">Phone Number</label>
                        <p class="fw-medium text-dark">{{ $contact->phone }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

{{--        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $contact->email }}" class="btn btn-primary">
                            <i class="fas fa-reply me-2"></i> Reply via Email
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
