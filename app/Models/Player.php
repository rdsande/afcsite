<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'jersey_number',
        'position',
        'team_category',
        'date_of_birth',
        'nationality',
        'height',

        'biography',
        'video_reel_link',
        'profile_image',
        'is_active',
        'is_captain',
        // Statistical fields
        'goals_inside_box',
        'goals_outside_box',
        'assists',
        'passes_completed',
        'passes_lost',
        'tackles_won',
        'tackles_lost',
        'interceptions',
        'clearances',
        'blocks',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'height' => 'decimal:2',

        'jersey_number' => 'integer',
        'goals' => 'integer',
        'assists' => 'integer',
        'appearances' => 'integer',
        'is_active' => 'boolean',
        'is_captain' => 'boolean',
        // Statistical fields
        'goals_inside_box' => 'integer',
        'goals_outside_box' => 'integer',
        'passes_completed' => 'integer',
        'passes_lost' => 'integer',
        'tackles_won' => 'integer',
        'tackles_lost' => 'integer',
        'interceptions' => 'integer',
        'clearances' => 'integer',
        'blocks' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSenior($query)
    {
        return $query->where('team_category', 'senior');
    }

    public function scopeAcademy($query)
    {
        return $query->where('team_category', 'academy');
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeCaptains($query)
    {
        return $query->where('is_captain', true);
    }

    // Boot method to auto-generate slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($player) {
            if (empty($player->slug)) {
                $player->slug = static::generateUniqueSlug($player->name);
            }
        });
        
        static::updating(function ($player) {
            if ($player->isDirty('name') && empty($player->slug)) {
                $player->slug = static::generateUniqueSlug($player->name);
            }
        });
    }
    
    // Generate unique slug
    private static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;
        
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    // Accessors
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : null;
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getGoalsPerGameAttribute()
    {
        return $this->appearances > 0 ? round($this->goals / $this->appearances, 2) : 0;
    }

    public function getAssistsPerGameAttribute()
    {
        return $this->appearances > 0 ? round($this->assists / $this->appearances, 2) : 0;
    }

    // Helper methods
    public function addGoal()
    {
        $this->increment('goals');
    }

    public function addAssist()
    {
        $this->increment('assists');
    }

    public function addAppearance()
    {
        $this->increment('appearances');
    }

    public function getPositionDisplayAttribute()
    {
        $positions = [
            'GK' => 'Goalkeeper',
            'CB' => 'Centre Back',
            'LB' => 'Left Back',
            'RB' => 'Right Back',
            'CDM' => 'Defensive Midfielder',
            'CM' => 'Central Midfielder',
            'CAM' => 'Attacking Midfielder',
            'LW' => 'Left Winger',
            'RW' => 'Right Winger',
            'ST' => 'Striker',
            'CF' => 'Centre Forward'
        ];

        return $positions[$this->position] ?? $this->position;
    }
}
