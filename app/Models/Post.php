<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- ADD THIS IMPORT
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Ensure 'image' is added to fillable so it can be saved
    protected $guarded = [];


}
