<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FootballMatch extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'home_team',
        'away_team',
        'home_team_logo',
        'away_team_logo',
        'match_date',
        'venue',
        'competition_type',
        'home_goals',
        'away_goals',
        'home_penalties',
        'away_penalties',
        'goal_scorers',
        'yellow_cards',
        'red_cards',
        'attendance',
        'match_report',
        'status',
        'team_category'
    ];

    protected $casts = [
        'match_date' => 'datetime',
        'home_goals' => 'integer',
        'away_goals' => 'integer',
        'home_penalties' => 'integer',
        'away_penalties' => 'integer',
        'goal_scorers' => 'json',
        'yellow_cards' => 'json',
        'red_cards' => 'json',
        'attendance' => 'integer'
    ];

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeRecent($query)
    {
        return $query->where('match_date', '<=', now())
                    ->orderBy('match_date', 'desc');
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

    public function scopeWins($query)
    {
        return $query->whereRaw('(
            (home_team LIKE "%Azam FC%" AND home_goals > away_goals) OR
            (away_team LIKE "%Azam FC%" AND away_goals > home_goals)
        )');
    }

    public function scopeLosses($query)
    {
        return $query->whereRaw('(
            (home_team LIKE "%Azam FC%" AND home_goals < away_goals) OR
            (away_team LIKE "%Azam FC%" AND away_goals < home_goals)
        )');
    }

    public function scopeDraws($query)
    {
        return $query->where('home_goals', '=', 'away_goals')
                    ->whereRaw('(home_team LIKE "%Azam FC%" OR away_team LIKE "%Azam FC%")');
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

    public function getAzamGoalsAttribute()
    {
        return $this->is_home_game ? $this->home_goals : $this->away_goals;
    }

    public function getOpponentGoalsAttribute()
    {
        return $this->is_home_game ? $this->away_goals : $this->home_goals;
    }

    public function getResultAttribute()
    {
        if ($this->status !== 'completed') {
            return 'N/A';
        }

        $azamGoals = $this->azam_goals;
        $opponentGoals = $this->opponent_goals;

        if ($azamGoals > $opponentGoals) {
            return 'W';
        } elseif ($azamGoals < $opponentGoals) {
            return 'L';
        } else {
            return 'D';
        }
    }

    public function getScorelineAttribute()
    {
        if ($this->status !== 'completed') {
            return 'vs';
        }

        return $this->is_home_game 
            ? "{$this->home_goals} - {$this->away_goals}"
            : "{$this->away_goals} - {$this->home_goals}";
    }

    public function getFormattedDateAttribute()
    {
        return $this->match_date->format('M d, Y');
    }

    public function getFormattedTimeAttribute()
    {
        return $this->match_date->format('H:i');
    }

    public function getTotalGoalsAttribute()
    {
        return $this->home_goals + $this->away_goals;
    }

    // Helper methods
    public function addGoalScorer($player, $minute, $type = 'goal')
    {
        $goalScorers = $this->goal_scorers ?? [];
        $goalScorers[] = [
            'player' => $player,
            'minute' => $minute,
            'type' => $type // goal, penalty, own_goal
        ];
        $this->update(['goal_scorers' => $goalScorers]);
    }

    public function addCard($player, $minute, $type)
    {
        $cards = $type === 'yellow' ? ($this->yellow_cards ?? []) : ($this->red_cards ?? []);
        $cards[] = [
            'player' => $player,
            'minute' => $minute
        ];
        
        $field = $type === 'yellow' ? 'yellow_cards' : 'red_cards';
        $this->update([$field => $cards]);
    }

    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
    }

    public function getMatchSummary()
    {
        return [
            'result' => $this->result,
            'scoreline' => $this->scoreline,
            'opponent' => $this->opponent,
            'venue' => $this->is_home_game ? 'Home' : 'Away',
            'competition' => $this->competition_type,
            'date' => $this->formatted_date
        ];
    }
}
