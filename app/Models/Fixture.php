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
        'is_home',
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
        'is_home' => 'boolean',
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
        return stripos($this->home_team, 'Azam FC') !== false;
    }

    public function getOpponentAttribute()
    {
        return $this->is_home_game ? $this->away_team : $this->home_team;
    }

    public function getOpponentLogoAttribute()
    {
        return $this->is_home_game ? $this->away_team_logo : $this->home_team_logo;
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
