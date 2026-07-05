@extends('layouts.admin.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">
        <h6 class="mb-4">{{ isset($archivePlaylist) ? 'Edit Playlist' : 'Create New Playlist' }}</h6>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($archivePlaylist) ? route('admin.archive-playlists.update', $archivePlaylist->id) : route('admin.archive-playlists.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($archivePlaylist))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5 class="border-bottom pb-2">Playlist Info</h5>
                    <div class="mb-3">
                        <label class="form-label">Badge Label (e.g., FEATURED VIDEO)</label>
                        <input type="text" name="badge_label" class="form-control" value="{{ old('badge_label', $archivePlaylist->badge_label ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $archivePlaylist->title ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $archivePlaylist->description ?? '') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Playlist Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                            @if(isset($archivePlaylist) && $archivePlaylist->thumbnail)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $archivePlaylist->thumbnail) }}" width="100" class="rounded">
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sort Order (Queue)</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $archivePlaylist->sort_order ?? 0) }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                        <h5 class="mb-0">Media Content</h5>
                        <button type="button" class="btn btn-success btn-sm" onclick="addMediaRow()">+ Add Media</button>
                    </div>

                    @if(isset($archivePlaylist) && $archivePlaylist->media->count() > 0)
                        <div class="mb-4 p-3 bg-white border rounded">
                            <h6>Current Media Items</h6>
                            <ul class="list-group" id="existing-media-list">
                                @foreach($archivePlaylist->media as $media)
                                    <li class="list-group-item d-flex justify-content-between align-items-center" id="media-item-{{ $media->id }}">
                                        <div>
                                            <span class="badge bg-primary me-2">{{ strtoupper($media->type) }}</span>
                                            @if($media->type === 'video')
                                                <a href="{{ asset('storage/' . $media->url) }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 200px; vertical-align: middle;">View Video File</a>
                                            @else
                                                <img src="{{ asset('storage/' . $media->url) }}" height="30" class="rounded me-2">
                                            @endif
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteExistingMedia({{ $media->id }})">Remove</button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div id="media-container">
                        </div>
                    <small class="text-muted d-block mt-2"><i class="fas fa-info-circle"></i> Videos are often large files. Uploading multiple videos at once may take time depending on your connection.</small>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary px-5 py-2">Save Playlist</button>
        </form>
    </div>
</div>

<script>
    let mediaIndex = 0;

    function addMediaRow() {
        const container = document.getElementById('media-container');
        const row = document.createElement('div');
        row.className = 'card mb-3 border-0 shadow-sm';
        row.id = `media-row-${mediaIndex}`;

        row.innerHTML = `
            <div class="card-body bg-white rounded border border-light p-3 position-relative">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" aria-label="Close" onclick="removeMediaRow(${mediaIndex})"></button>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label class="form-label text-muted small">Media Type</label>
                        <select name="media[${mediaIndex}][type]" class="form-select form-select-sm">
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="form-label text-muted small">Order</label>
                        <input type="number" name="media[${mediaIndex}][sort_order]" class="form-control form-control-sm" value="0">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-muted small">Upload File</label>
                        <input type="file" name="media[${mediaIndex}][file]" class="form-control form-control-sm" accept="image/*,video/*">
                    </div>
                </div>
            </div>
        `;

        container.appendChild(row);
        mediaIndex++;
    }

    function removeMediaRow(index) {
        const row = document.getElementById(`media-row-${index}`);
        if (row) {
            row.remove();
        }
    }

    function deleteExistingMedia(id) {
        if(confirm('Are you sure you want to permanently delete this media item?')) {
            fetch(`/admin/archive-playlists/media/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById(`media-item-${id}`).remove();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }

    // Add one empty row by default on create page
    @if(!isset($archivePlaylist))
        addMediaRow();
    @endif
</script>
@endsection
