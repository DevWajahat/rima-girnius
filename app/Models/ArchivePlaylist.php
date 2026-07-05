<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivePlaylist extends Model
{
    protected $guarded = [];

    public function media()
    {
        return $this->hasMany(ArchiveMedia::class)->orderBy('sort_order', 'asc');
    }
}
