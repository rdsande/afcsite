<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'home_team_id',
        'away_team_id',
        'match_date',
        'stadium',
        'competition_type',
        'match_type',
        'team_category',
        'match_preview',
        'ticket_link',
        'ticket_price',
        'status',
        'home_score',
        'away_score',
        'match_report',
        'attendance',
        'referee',
        'team_lineups',
        'is_featured',
        'broadcast_link'
    ];

    protected $casts = [
        'match_date' => 'datetime',
        'ticket_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'team_lineups' => 'array'
    ];

    // Relationships
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function matchEvents()
    {
        return $this->hasMany(MatchEvent::class)->ordered();
    }

    public function goals()
    {
        return $this->hasMany(MatchEvent::class)->goals();
    }

    public function cards()
    {
        return $this->hasMany(MatchEvent::class)->cards();
    }

    public function liveUpdates()
    {
        return $this->hasMany(MatchEvent::class)->liveUpdates()->ordered();
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('match_date', '>', now())
                    ->where('status', 'scheduled');
    }

    public function scopePast($query)
    {
        return $query->where('match_date', '<', now())
                    ->orWhere('status', 'completed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('match_date', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('match_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeSenior($query)
    {
        return $query->where('team_category', 'senior');
    }

    public function scopeAcademy($query)
    {
        return $query->where('team_category', 'academy');
    }

    public function scopeByCompetition($query, $competition)
    {
        return $query->where('competition_type', $competition);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeWithResults($query)
    {
        return $query->whereNotNull('home_score')->whereNotNull('away_score');
    }

    public function scopeByTournament($query, $tournamentId)
    {
        return $query->where('tournament_id', $tournamentId);
    }

    // Accessors
    public function getIsHomeGameAttribute()
    {
        $azamTeam = Team::where('name', 'like', '%Azam FC%')->first();
        if (!$azamTeam) {
            return false;
        }
        return $this->home_team_id == $azamTeam->id;
    }

    public function getOpponentAttribute()
    {
        if ($this->is_home_game) {
            return $this->awayTeam ? $this->awayTeam->name : null;
        } else {
            return $this->homeTeam ? $this->homeTeam->name : null;
        }
    }

    public function getOpponentLogoAttribute()
    {
        if ($this->is_home_game) {
            return $this->awayTeam ? $this->awayTeam->logo : null;
        } else {
            return $this->homeTeam ? $this->homeTeam->logo : null;
        }
    }

    public function getMatchStatusAttribute()
    {
        if ($this->status === 'completed') {
            return 'Completed';
        }
        
        if ($this->status === 'cancelled') {
            return 'Cancelled';
        }
        
        if ($this->status === 'postponed') {
            return 'Postponed';
        }
        
        if ($this->match_date->isPast()) {
            return 'Live/Finished';
        }
        
        return 'Upcoming';
    }

    public function getTimeUntilMatchAttribute()
    {
        if ($this->match_date->isPast()) {
            return null;
        }
        
        return $this->match_date->diffForHumans();
    }

    public function getFormattedDateAttribute()
    {
        return $this->match_date->format('M d, Y');
    }

    public function getFormattedTimeAttribute()
    {
        return $this->match_date->format('H:i');
    }

    public function getResultAttribute()
    {
        if ($this->home_score !== null && $this->away_score !== null) {
            return $this->home_score . ' - ' . $this->away_score;
        }
        return null;
    }

    /**
     * Get match result from Azam FC's perspective
     * Returns: 'win', 'loss', 'draw', or null if no result
     */
    public function getAzamResultAttribute()
    {
        if ($this->home_score === null || $this->away_score === null) {
            return null;
        }

        $azamTeam = Team::where('name', 'like', '%Azam FC%')->first();
        if (!$azamTeam) {
            return null;
        }

        $isAzamHome = $this->home_team_id == $azamTeam->id;
        $isAzamAway = $this->away_team_id == $azamTeam->id;
        
        if (!$isAzamHome && !$isAzamAway) {
            return null; // Azam FC not playing in this match
        }

        if ($this->home_score == $this->away_score) {
            return 'draw';
        }

        if ($isAzamHome) {
            return $this->home_score > $this->away_score ? 'win' : 'loss';
        } else {
            return $this->away_score > $this->home_score ? 'win' : 'loss';
        }
    }

    /**
     * Check if Azam FC is playing in this fixture
     */
    public function getIsAzamFixtureAttribute()
    {
        $azamTeam = Team::where('name', 'like', '%Azam FC%')->first();
        if (!$azamTeam) {
            return false;
        }
        
        return $this->home_team_id == $azamTeam->id || $this->away_team_id == $azamTeam->id;
    }

    /**
     * Get Azam FC's score in this match
     */
    public function getAzamScoreAttribute()
    {
        if (!$this->is_azam_fixture) {
            return null;
        }

        $azamTeam = Team::where('name', 'like', '%Azam FC%')->first();
        if ($this->home_team_id == $azamTeam->id) {
            return $this->home_score;
        } else {
            return $this->away_score;
        }
    }

    /**
     * Get opponent's score in this match
     */
    public function getOpponentScoreAttribute()
    {
        if (!$this->is_azam_fixture) {
            return null;
        }

        $azamTeam = Team::where('name', 'like', '%Azam FC%')->first();
        if ($this->home_team_id == $azamTeam->id) {
            return $this->away_score;
        } else {
            return $this->home_score;
        }
    }

    public function getHomeGoalsAttribute()
    {
        return $this->goals()->where('team', 'home')->count();
    }

    public function getAwayGoalsAttribute()
    {
        return $this->goals()->where('team', 'away')->count();
    }

    public function getHasResultAttribute()
    {
        return $this->home_score !== null && $this->away_score !== null;
    }

    public function getIsLiveAttribute()
    {
        return $this->status === 'live';
    }

    public function getMatchDayAttribute()
    {
        return $this->match_date->format('l, M d, Y');
    }

    // Helper methods
    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
    }

    public function markAsCancelled()
    {
        $this->update(['status' => 'cancelled']);
    }

    public function markAsPostponed()
    {
        $this->update(['status' => 'postponed']);
    }
}
