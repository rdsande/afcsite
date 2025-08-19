<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'description',
        'type',
        'format',
        'start_date',
        'end_date',
        'season',
        'is_active',
        'logo',
        'settings'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'settings' => 'array'
    ];

    // Relationships
    public function fixtures()
    {
        return $this->hasMany(Fixture::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeCurrentSeason($query)
    {
        $currentYear = now()->year;
        $nextYear = $currentYear + 1;
        $season = $currentYear . '/' . substr($nextYear, -2);
        
        return $query->where('season', $season);
    }

    // Accessors
    public function getIsCurrentAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return false;
        }
        
        $now = now();
        return $now->between($this->start_date, $this->end_date);
    }

    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'Inactive';
        }
        
        if (!$this->start_date || !$this->end_date) {
            return 'Active';
        }
        
        $now = now();
        
        if ($now->lt($this->start_date)) {
            return 'Upcoming';
        }
        
        if ($now->between($this->start_date, $this->end_date)) {
            return 'Ongoing';
        }
        
        return 'Completed';
    }
}
