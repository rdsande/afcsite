<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExclusiveStory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'description',
        'media_paths',
        'video_link',
        'thumbnail',
        'thumbnail_path',
        'is_active',
        'is_featured',
        'order_position'
    ];

    protected $casts = [
        'media_paths' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_position', 'asc')->orderBy('created_at', 'desc');
    }
}
