<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class AdminNotice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'type',
        'priority',
        'is_active',
        'is_dismissible',
        'show_on_dashboard',
        'show_on_login',
        'starts_at',
        'expires_at',
        'created_by',
        'updated_by',
        'target_audience',
        'view_count'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_dismissible' => 'boolean',
        'show_on_dashboard' => 'boolean',
        'show_on_login' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'target_audience' => 'array'
    ];

    // Relationships
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVisible($query)
    {
        $now = Carbon::now();
        return $query->active()
            ->where(function ($q) use ($now) {
                $q->whereNull('starts_at')
                  ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', $now);
            });
    }

    public function scopeForDashboard($query)
    {
        return $query->visible()->where('show_on_dashboard', true);
    }

    public function scopeForLogin($query)
    {
        return $query->visible()->where('show_on_login', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    // Helper methods
    public function isVisible(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();
        
        if ($this->starts_at && $this->starts_at->gt($now)) {
            return false;
        }
        
        if ($this->expires_at && $this->expires_at->lt($now)) {
            return false;
        }
        
        return true;
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->lt(Carbon::now());
    }

    public function isScheduled(): bool
    {
        return $this->starts_at && $this->starts_at->gt(Carbon::now());
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'success' => 'success',
            'warning' => 'warning',
            'danger' => 'danger',
            'info' => 'primary',
            default => 'primary'
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'high' => 'danger',
            'medium' => 'warning',
            'low' => 'success',
            default => 'primary'
        };
    }

    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'inactive';
        }
        
        if ($this->isExpired()) {
            return 'expired';
        }
        
        if ($this->isScheduled()) {
            return 'scheduled';
        }
        
        return 'active';
    }
}
