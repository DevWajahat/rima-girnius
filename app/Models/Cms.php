<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Cms extends Model
{
    protected $guarded = [];


    public function meta(): HasMany
    {
        return $this->hasMany(CmsMeta::class);
    }

}
