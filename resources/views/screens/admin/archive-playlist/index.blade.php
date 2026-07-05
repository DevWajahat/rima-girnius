@extends('layouts.admin.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded h-100 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="mb-0">Archive Playlists</h6>
            <a href="{{ route('admin.archive-playlists.create') }}" class="btn btn-primary btn-sm">Add New Playlist</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Order</th>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Label / Title</th>
                        <th scope="col">Media Count</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($playlists as $playlist)
                    <tr>
                        <td>{{ $playlist->sort_order }}</td>
                        <td>
                            @if($playlist->thumbnail)
                                <img src="{{ asset('storage/' . $playlist->thumbnail) }}" alt="thumb" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 4px;">N/A</div>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted text-uppercase fw-bold">{{ $playlist->badge_label }}</small><br>
                            <strong>{{ $playlist->title }}</strong>
                        </td>
                        <td><span class="badge bg-info">{{ $playlist->media_count }} items</span></td>
                        <td>
                            <a href="{{ route('admin.archive-playlists.edit', $playlist->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.archive-playlists.destroy', $playlist->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this playlist and all its media?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No playlists found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
