<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsMeta extends Model
{
    protected $guarded = [];

    public function cms(): BelongsTo
    {
        return $this->BelongsTo(Cms::class);
    }

}
