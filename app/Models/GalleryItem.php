<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'activity_date',
        'slug',
        'images',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'images' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}