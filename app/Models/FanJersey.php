<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class FanJersey extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'fan_id',
        'jersey_id',
        'custom_name',
        'custom_number',
        'size',
        'customizations',
        'status',
        'total_price',
        'order_reference',
        'ordered_at',
        'completed_at'
    ];
    
    protected $casts = [
        'customizations' => 'array',
        'total_price' => 'decimal:2',
        'ordered_at' => 'datetime',
        'completed_at' => 'datetime'
    ];
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($fanJersey) {
            if (empty($fanJersey->order_reference)) {
                $fanJersey->order_reference = 'AZ' . strtoupper(Str::random(8));
            }
            if (empty($fanJersey->ordered_at)) {
                $fanJersey->ordered_at = now();
            }
        });
    }
    
    /**
     * Get the fan that owns the jersey.
     */
    public function fan(): BelongsTo
    {
        return $this->belongsTo(Fan::class);
    }
    
    /**
     * Get the jersey template.
     */
    public function jersey(): BelongsTo
    {
        return $this->belongsTo(Jersey::class);
    }
    
    /**
     * Scope to get jerseys by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
