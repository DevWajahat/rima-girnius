<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\BelongsTo;


class BookImage extends Model
{
    protected $guarded = [];

    public function Book() :BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

}
