<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'season',
        'team_id',
        'matches_played',
        'wins',
        'draws',
        'losses',
        'goals_for',
        'goals_against',
        'goal_difference',
        'points',
        'position',
        'form',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the team that belongs to this league entry.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Scope for active leagues.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for current season.
     */
    public function scopeCurrentSeason($query)
    {
        $currentSeason = date('Y') . '/' . (date('Y') + 1);
        return $query->where('season', $currentSeason);
    }

    /**
     * Scope for specific league.
     */
    public function scopeForLeague($query, $leagueName)
    {
        return $query->where('name', $leagueName);
    }

    /**
     * Get standings ordered by position.
     */
    public function scopeStandings($query)
    {
        return $query->orderBy('points', 'desc')
                    ->orderBy('goal_difference', 'desc')
                    ->orderBy('goals_for', 'desc');
    }

    /**
     * Calculate and update goal difference.
     */
    public function updateGoalDifference()
    {
        $this->goal_difference = $this->goals_for - $this->goals_against;
        $this->save();
    }

    /**
     * Calculate and update points based on wins and draws.
     */
    public function updatePoints()
    {
        $this->points = ($this->wins * 3) + $this->draws;
        $this->save();
    }

    /**
     * Update form string (last 5 matches).
     */
    public function updateForm($result)
    {
        $form = $this->form ?? '';
        $form = $result . '-' . $form;
        
        // Keep only last 5 results
        $formArray = explode('-', $form);
        $formArray = array_slice($formArray, 0, 5);
        
        $this->form = implode('-', array_filter($formArray));
        $this->save();
    }

    /**
     * Get formatted form with colors.
     */
    public function getFormattedFormAttribute()
    {
        if (!$this->form) return '';
        
        $results = explode('-', $this->form);
        $formatted = [];
        
        foreach ($results as $result) {
            $class = match($result) {
                'W' => 'text-success',
                'D' => 'text-warning', 
                'L' => 'text-danger',
                default => ''
            };
            $formatted[] = "<span class='$class'>$result</span>";
        }
        
        return implode(' ', $formatted);
    }

    /**
     * Static method to get current season standings.
     */
    public static function getCurrentStandings($leagueName = 'NBC Premier League')
    {
        return self::with('team')
                  ->active()
                  ->currentSeason()
                  ->forLeague($leagueName)
                  ->standings()
                  ->get();
    }

    /**
     * Static method to update positions based on current standings.
     */
    public static function updatePositions($leagueName = 'NBC Premier League', $season = null)
    {
        if (!$season) {
            $season = date('Y') . '/' . (date('Y') + 1);
        }

        $standings = self::where('name', $leagueName)
                        ->where('season', $season)
                        ->where('is_active', true)
                        ->orderBy('points', 'desc')
                        ->orderBy('goal_difference', 'desc')
                        ->orderBy('goals_for', 'desc')
                        ->get();

        foreach ($standings as $index => $standing) {
            $standing->position = $index + 1;
            $standing->save();
        }
    }
}
