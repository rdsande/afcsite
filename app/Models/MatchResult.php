<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MatchResult extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'opponent',
        'match_date',
        'venue',
        'is_home',
        'competition',
        'azam_score',
        'opponent_score',
        'result',
        'attendance',
        'match_report',
        'fixture_id',
    ];

    protected $casts = [
        'match_date' => 'datetime',
        'is_home' => 'boolean',
        'azam_score' => 'integer',
        'opponent_score' => 'integer',
        'attendance' => 'integer',
    ];

    /**
     * Get the fixture that this match is based on.
     */
    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    /**
     * Scope for home matches.
     */
    public function scopeHome($query)
    {
        return $query->where('is_home', true);
    }

    /**
     * Scope for away matches.
     */
    public function scopeAway($query)
    {
        return $query->where('is_home', false);
    }

    /**
     * Scope for recent matches.
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('match_date', 'desc')->limit($limit);
    }

    /**
     * Scope for upcoming matches.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('match_date', '>', now())->orderBy('match_date', 'asc');
    }

    /**
     * Scope for completed matches.
     */
    public function scopeCompleted($query)
    {
        return $query->where('match_date', '<', now())->orderBy('match_date', 'desc');
    }

    /**
     * Scope for wins.
     */
    public function scopeWins($query)
    {
        return $query->where('result', 'win');
    }

    /**
     * Scope for losses.
     */
    public function scopeLosses($query)
    {
        return $query->where('result', 'loss');
    }

    /**
     * Scope for draws.
     */
    public function scopeDraws($query)
    {
        return $query->where('result', 'draw');
    }

    /**
     * Get formatted match date.
     */
    public function getFormattedDateAttribute()
    {
        return $this->match_date->format('M d, Y');
    }

    /**
     * Get formatted match time.
     */
    public function getFormattedTimeAttribute()
    {
        return $this->match_date->format('H:i');
    }

    /**
     * Get match status.
     */
    public function getStatusAttribute()
    {
        if ($this->match_date > now()) {
            return 'upcoming';
        } elseif ($this->azam_score !== null && $this->opponent_score !== null) {
            return 'completed';
        } else {
            return 'live';
        }
    }

    /**
     * Get match score display.
     */
    public function getScoreDisplayAttribute()
    {
        if ($this->azam_score !== null && $this->opponent_score !== null) {
            return $this->azam_score . ' - ' . $this->opponent_score;
        }
        return 'vs';
    }

    /**
     * Get result badge class.
     */
    public function getResultBadgeClassAttribute()
    {
        switch ($this->result) {
            case 'win':
                return 'badge-success';
            case 'loss':
                return 'badge-danger';
            case 'draw':
                return 'badge-warning';
            default:
                return 'badge-secondary';
        }
    }

    /**
     * Determine match result based on scores.
     */
    public function determineResult()
    {
        if ($this->azam_score === null || $this->opponent_score === null) {
            return null;
        }

        if ($this->azam_score > $this->opponent_score) {
            return 'win';
        } elseif ($this->azam_score < $this->opponent_score) {
            return 'loss';
        } else {
            return 'draw';
        }
    }

    /**
     * Update result when scores are set.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($match) {
            if ($match->azam_score !== null && $match->opponent_score !== null) {
                $match->result = $match->determineResult();
            }
        });
    }
}