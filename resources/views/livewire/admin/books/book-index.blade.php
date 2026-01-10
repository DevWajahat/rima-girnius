<div class="container-fluid p-4">

    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Manage Books</h2>
            <p class="text-muted mb-0">Upload and manage your digital products.</p>
        </div>
        <a href="{{ route('admin.books.create') }}" wire:navigate class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus me-2"></i> Add New Book
        </a>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            {{-- Search Bar --}}
            <div class="row g-3 mb-4">
                <div class="col-md-5 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text"
                               class="form-control border-start-0 bg-light"
                               placeholder="Search by Title or ID..."
                               wire:model.live.debounce.300ms="search">
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-3 text-uppercase text-secondary small fw-bold" wire:click="sortBy('id')" style="cursor: pointer;">
                                ID <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 text-uppercase text-secondary small fw-bold">Cover</th>
                            <th class="py-3 text-uppercase text-secondary small fw-bold" wire:click="sortBy('title')" style="cursor: pointer;">
                                Book Details <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 text-uppercase text-secondary small fw-bold" wire:click="sortBy('price')" style="cursor: pointer;">
                                Price <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 text-uppercase text-secondary small fw-bold" wire:click="sortBy('is_published')" style="cursor: pointer;">
                                Status <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 text-uppercase text-secondary small fw-bold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                            <tr wire:key="book-{{ $book->id }}">
                                {{-- ID --}}
                                <td class="ps-3 fw-bold text-muted">#{{ $book->id }}</td>

                                {{-- Cover Image --}}
                                <td>
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                             class="rounded shadow-sm border"
                                             style="width: 45px; height: 65px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded border d-flex align-items-center justify-content-center text-muted small"
                                             style="width: 45px; height: 65px;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- Title & Description --}}
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $book->title }}</span>
                                        <small class="text-muted text-truncate" style="max-width: 250px;">
                                            {{ \Illuminate\Support\Str::limit($book->description, 50) }}
                                        </small>
                                    </div>
                                </td>

                                {{-- Price Logic --}}
                                <td>
                                    <div class="d-flex flex-column">
                                        @if($book->sale_price < $book->price)
                                            {{-- ON SALE --}}
                                            <span class="text-danger fw-bold">${{ $book->sale_price }}</span>
                                            <small class="text-decoration-line-through text-muted" style="font-size: 0.75rem;">
                                                ${{ $book->price }}
                                            </small>
                                        @else
                                            {{-- REGULAR --}}
                                            <span class="fw-bold text-dark">${{ $book->price }}</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td>
                                    @if($book->is_published)
                                        <span class="badge bg-success bg-opacity-10 text-white px-2 py-1">
                                            <i class="fas fa-check-circle text-white me-1"></i> Published
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-white px-2 py-1">
                                            <i class="fas text-white fa-clock me-1"></i> Draft
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="text-center">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('admin.books.edit', $book->id) }}"
                                           wire:navigate
                                           class="btn btn-sm btn-white border"
                                           title="Edit">
                                            <i class="fas fa-pencil-alt text-warning"></i>
                                        </a>

                                        <button type="button"
                                                class="btn btn-sm btn-white border"
                                                wire:click="delete({{ $book->id }})"
                                                wire:confirm="Are you sure you want to delete this book? It will be moved to trash."
                                                title="Delete">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fas fa-book fa-3x text-light mb-3"></i>
                                        <h5 class="text-secondary">No books found</h5>
                                        <p class="text-muted small mb-0">Get started by creating your first book.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4 d-flex justify-content-end">
                {{ $books->links() }}
            </div>

        </div>
    </div>
</div>
