<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $guarded = [];


    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }


// Relationship to Book (NEW)
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }


}
