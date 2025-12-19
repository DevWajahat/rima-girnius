<div class="container-fluid p-4"> {{-- Added container padding --}}

    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Manage Blogs</h2>
            <p class="text-muted mb-0">Create, edit, and manage your website posts.</p>
        </div>
        <a href="{{ route('admin.blogs.create') }}" wire:navigate class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus me-2"></i> Create New Post
        </a>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Main Content Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4"> {{-- Increased padding inside the card --}}

            {{-- Top Controls: Search & Filter --}}
            <div class="row g-3 mb-4"> {{-- Added margin bottom to separate search from table --}}
                <div class="col-md-5 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text"
                               class="form-control border-start-0 bg-light"
                               placeholder="Search by Title or Tag..."
                               wire:model.live.debounce.300ms="search">
                    </div>
                </div>
                {{-- Optional: Add a filter dropdown here if needed later --}}
            </div>

            {{-- Data Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle"> {{-- align-middle centers content vertically --}}
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-3 border-bottom-0 text-uppercase text-secondary small fw-bold" wire:click="sortBy('id')" style="cursor: pointer;">
                                ID <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 border-bottom-0 text-uppercase text-secondary small fw-bold" wire:click="sortBy('title')" style="cursor: pointer;">
                                Title <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 border-bottom-0 text-uppercase text-secondary small fw-bold">SEO Keywords</th>
                            <th class="py-3 border-bottom-0 text-uppercase text-secondary small fw-bold">Tags</th>
                            <th class="py-3 border-bottom-0 text-uppercase text-secondary small fw-bold" wire:click="sortBy('created_at')" style="cursor: pointer;">
                                Created <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 border-bottom-0 text-center text-uppercase text-secondary small fw-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr wire:key="post-{{ $post->id }}">
                                <td class="ps-3 fw-bold text-muted">#{{ $post->id }}</td>

                                <td style="min-width: 250px;">
                                    <div class="d-flex flex-column py-2"> {{-- vertical padding for spacing --}}
                                        <span class="fw-bold text-dark fs-6">{{ $post->title }}</span>
                                        <small class="text-muted text-truncate" style="max-width: 300px;">
                                            {{ Str::limit($post->description, 60) }}
                                        </small>
                                    </div>
                                </td>

                                <td>
                                    @if($post->meta_keyword)
                                        <div class="d-flex flex-wrap gap-1" style="max-width: 200px;">
                                            @foreach(explode(',', $post->meta_keyword) as $keyword)
                                                @if($loop->iteration <= 2)
                                                    <span class="badge bg-light text-secondary border">{{ trim($keyword) }}</span>
                                                @endif
                                            @endforeach
                                            @if(count(explode(',', $post->meta_keyword)) > 2)
                                                <span class="badge bg-light text-secondary border">+{{ count(explode(',', $post->meta_keyword)) - 2 }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td>
                                    @if($post->tags)
                                        <span class="badge bg-primary bg-opacity-10 text-light px-2 py-1">{{ $post->tags }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">{{ $post->created_at->format('M d, Y') }}</span>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ $post->created_at->format('h:i A') }}</small>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('admin.blogs.edit', $post->id) }}" wire:navigate class="btn btn-sm btn-white border" title="Edit">
                                            <i class="fas fa-pencil-alt text-warning"></i>
                                        </a>
                                        <button class="btn btn-sm btn-white border"
                                                wire:click="delete({{ $post->id }})"
                                                wire:confirm="Delete this post?"
                                                title="Delete">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-5">
                                        <div class="mb-3">
                                            <i class="fas fa-file-alt fa-3x text-light"></i>
                                        </div>
                                        <h5 class="text-secondary">No posts found</h5>
                                        <p class="text-muted small mb-0">Get started by creating your first blog post.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4 d-flex justify-content-end">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
