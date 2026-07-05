<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;


class HomeController extends Controller
{
    public function index()
    {


        $posts = Post::limit(3)->get();

        return view('screens.web.index', get_defined_vars());
    }
    public function eurekaUniverse()
    {
        $cmsRecord = \App\Models\Cms::where('page', 'home')->where('type', 'social-poster-section')->first();
        $socialPosters = [];
        $heading = 'From The World Of Eureka';

        if ($cmsRecord) {
            $data = \App\Models\CmsMeta::where('cms_id', $cmsRecord->id)->pluck('meta_value', 'meta_key')->toArray();
            $heading = $data['posterHeading'] ?? $heading;
            $decoded = isset($data['posterImages']) ? json_decode($data['posterImages'], true) : [];
            $socialPosters = is_array($decoded) ? $decoded : [];
        }

        return view('screens.web.eureka-universe.index', compact('socialPosters', 'heading'));
    }

    public function archive()
    {
        // Only fetch the playlists (no media) to keep the initial load extremely lightweight
        $playlists = \App\Models\ArchivePlaylist::orderBy('sort_order', 'asc')->get();
        return view('screens.web.archive.index', compact('playlists'));
    }

    public function getPlaylistMedia($id)
    {
        // AJAX endpoint to fetch media for the requested playlist
        $media = \App\Models\ArchiveMedia::where('archive_playlist_id', $id)
            ->orderBy('sort_order', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $media
        ]);
    }
}
