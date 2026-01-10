<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\HasMany;


class Book extends Model
{
    protected $guarded = [];

    public function book_images(): HasMany
    {
        return $this->HasMany(BookImage::class);
    }

}
