<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageOverwrite extends Model
{
    protected $fillable = [
        'original_name',
        'stored_path',
        'exif_data',
    ];

    protected $casts = [
        'exif_data' => 'array',
    ];
}

