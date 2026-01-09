<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Contact Messages</h2>
            <p class="text-muted mb-0">View and manage inquiries from the website.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <div class="row g-3 mb-4">
                <div class="col-md-5 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text"
                               class="form-control border-start-0 bg-light"
                               placeholder="Search Name, Email, Subject..."
                               wire:model.live.debounce.300ms="search">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-3 border-bottom-0 text-uppercase text-secondary small fw-bold" wire:click="sortBy('id')" style="cursor: pointer;">
                                ID <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 border-bottom-0 text-uppercase text-secondary small fw-bold" wire:click="sortBy('name')" style="cursor: pointer;">
                                Sender Info <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 border-bottom-0 text-uppercase text-secondary small fw-bold" wire:click="sortBy('subject')" style="cursor: pointer;">
                                Subject <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 border-bottom-0 text-uppercase text-secondary small fw-bold" wire:click="sortBy('created_at')" style="cursor: pointer;">
                                Received <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 border-bottom-0 text-center text-uppercase text-secondary small fw-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                            <tr wire:key="contact-{{ $contact->id }}">
                                <td class="ps-3 fw-bold text-muted">#{{ $contact->id }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $contact->name }}</span>
                                        <small class="text-muted">{{ $contact->email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark">{{ Str::limit($contact->subject, 40) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">{{ $contact->created_at->format('M d, Y') }}</span>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ $contact->created_at->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('admin.contacts.show', $contact->id) }}" wire:navigate class="btn btn-sm btn-white border" title="Read Message">
                                            <i class="fas fa-eye text-primary"></i>
                                        </a>
                                        <button class="btn btn-sm btn-white border"
                                                wire:click="delete({{ $contact->id }})"
                                                wire:confirm="Delete this message?"
                                                title="Delete">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-5">
                                        <div class="mb-3">
                                            <i class="fas fa-inbox fa-3x text-light"></i>
                                        </div>
                                        <h5 class="text-secondary">No messages found</h5>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
</div>
