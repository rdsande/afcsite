<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jersey extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'type',
        'season',
        'template_image',
        'customization_options',
        'price',
        'is_active',
        'description'
    ];
    
    protected $casts = [
        'customization_options' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];
    
    /**
     * Get the fan jerseys for this jersey template.
     */
    public function fanJerseys(): HasMany
    {
        return $this->hasMany(FanJersey::class);
    }
    
    /**
     * Scope to get only active jerseys.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope to get jerseys by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
    
    /**
     * Get the template image attribute with corrected path.
     */
    public function getTemplateImageAttribute($value)
    {
        // Remove duplicate 'jerseys/' from path if present
        if ($value && strpos($value, 'jerseys/jerseys/') !== false) {
            return str_replace('jerseys/jerseys/', 'jerseys/', $value);
        }
        
        return $value;
    }
}
