<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FanMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'fan_id',
        'subject',
        'message',
        'category',
        'priority',
        'status',
        'admin_reply',
        'replied_by',
        'replied_at',
        'is_spam',
        'ip_address',
        'attachments'
    ];

    protected $casts = [
        'replied_at' => 'datetime',
        'is_spam' => 'boolean',
        'attachments' => 'array'
    ];

    // Relationships
    public function fan(): BelongsTo
    {
        return $this->belongsTo(Fan::class);
    }

    public function repliedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    // Scopes
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeNotSpam($query)
    {
        return $query->where('is_spam', false);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'open');
    }

    // Helper methods
    public function isReplied(): bool
    {
        return !is_null($this->admin_reply);
    }

    public function isPending(): bool
    {
        return $this->status === 'open';
    }

    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }

    public function markAsSpam(): void
    {
        $this->update(['is_spam' => true, 'status' => 'closed']);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'in_progress' => 'primary',
            'resolved' => 'success',
            'closed' => 'danger',
            default => 'secondary'
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'high' => 'danger',
            'medium' => 'warning',
            'low' => 'success',
            default => 'secondary'
        };
    }
}
