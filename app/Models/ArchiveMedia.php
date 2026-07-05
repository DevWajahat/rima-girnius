<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveMedia extends Model
{
    protected $guarded = [];

    public function playlist()
    {
        return $this->belongsTo(ArchivePlaylist::class, 'archive_playlist_id');
    }
}
