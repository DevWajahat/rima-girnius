<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArchivePlaylist;
use App\Models\ArchiveMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArchivePlaylistController extends Controller
{
    public function index()
    {
        // Load with media count to keep query optimized
        $playlists = ArchivePlaylist::withCount('media')->orderBy('sort_order', 'asc')->get();
        return view('screens.admin.archive-playlist.index', compact('playlists'));
    }

    public function create()
    {
        return view('screens.admin.archive-playlist.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'badge_label' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048', // Max 2MB for thumbnail
            'sort_order' => 'nullable|integer',
            'media.*.type' => 'required|in:image,video',
            'media.*.file' => 'nullable|file', // Accepts any file, size limit depends on php.ini
        ]);

        try {
            DB::beginTransaction();

            $playlistData = $request->only(['badge_label', 'title', 'description', 'sort_order']);

            if ($request->hasFile('thumbnail')) {
                $playlistData['thumbnail'] = $request->file('thumbnail')->store('archives/thumbnails', 'public');
            }

            $playlist = ArchivePlaylist::create($playlistData);

            $this->processMediaUploads($request, $playlist->id);

            DB::commit();
            return redirect()->route('admin.archive-playlists.index')->with('success', 'Playlist created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating playlist: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(ArchivePlaylist $archivePlaylist)
    {
        $archivePlaylist->load('media');
        return view('screens.admin.archive-playlist.form', compact('archivePlaylist'));
    }

    public function update(Request $request, ArchivePlaylist $archivePlaylist)
    {
        $request->validate([
            'badge_label' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
            'media.*.type' => 'required|in:image,video',
            'media.*.file' => 'nullable|file',
        ]);

        try {
            DB::beginTransaction();

            $playlistData = $request->only(['badge_label', 'title', 'description', 'sort_order']);

            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($archivePlaylist->thumbnail) {
                    Storage::disk('public')->delete($archivePlaylist->thumbnail);
                }
                $playlistData['thumbnail'] = $request->file('thumbnail')->store('archives/thumbnails', 'public');
            }

            $archivePlaylist->update($playlistData);

            // Process any newly added media in the edit form
            $this->processMediaUploads($request, $archivePlaylist->id);

            DB::commit();
            return redirect()->route('admin.archive-playlists.index')->with('success', 'Playlist updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating playlist: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(ArchivePlaylist $archivePlaylist)
    {
        try {
            DB::beginTransaction();

            // Delete playlist thumbnail
            if ($archivePlaylist->thumbnail) {
                Storage::disk('public')->delete($archivePlaylist->thumbnail);
            }

            // Delete associated media files physically
            foreach ($archivePlaylist->media as $media) {
                if ($media->url) {
                    Storage::disk('public')->delete($media->url);
                }
            }

            $archivePlaylist->delete(); // This cascades DB deletion because of migration

            DB::commit();
            return redirect()->route('admin.archive-playlists.index')->with('success', 'Playlist deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting playlist: ' . $e->getMessage());
        }
    }

    public function destroyMedia(ArchiveMedia $archiveMedia)
    {
        if ($archiveMedia->url) {
            Storage::disk('public')->delete($archiveMedia->url);
        }
        $archiveMedia->delete();
        return response()->json(['success' => true, 'message' => 'Media deleted.']);
    }

    /**
     * Helper to handle bulk media uploads efficiently
     */
    private function processMediaUploads(Request $request, $playlistId)
    {
        if ($request->has('media') && is_array($request->media)) {
            foreach ($request->media as $index => $mediaItem) {
                // Only process if an actual file was uploaded in this row
                if ($request->hasFile("media.{$index}.file")) {
                    $file = $request->file("media.{$index}.file");
                    $finalUrl = $file->store('archives/media', 'public');

                    ArchiveMedia::create([
                        'archive_playlist_id' => $playlistId,
                        'type' => $mediaItem['type'] ?? 'image',
                        'url' => $finalUrl,
                        'sort_order' => $mediaItem['sort_order'] ?? 0,
                    ]);
                }
            }
        }
    }
}
