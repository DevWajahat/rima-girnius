<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\BelongsTo;


class Order extends Model
{
    protected $guarded = [];


    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function order() :BelongsTo
    {
        return $this->belongsTo(Book::class);
    }



}
