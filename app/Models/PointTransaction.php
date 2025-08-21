<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PointTransaction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'fan_id',
        'points',
        'type',
        'description',
        'metadata'
    ];
    
    protected $casts = [
        'metadata' => 'array'
    ];
    
    /**
     * Get the fan that owns the point transaction.
     */
    public function fan(): BelongsTo
    {
        return $this->belongsTo(Fan::class);
    }
}
