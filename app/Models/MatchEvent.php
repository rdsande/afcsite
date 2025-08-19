<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MatchEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'fixture_id',
        'player_id',
        'event_type',
        'minute',
        'team',
        'description',
        'metadata',
        'event_time',
        'is_live_update',
        'sort_order'
    ];

    protected $casts = [
        'metadata' => 'array',
        'event_time' => 'datetime',
        'is_live_update' => 'boolean'
    ];

    // Event type constants
    const EVENT_GOAL = 'goal';
    const EVENT_YELLOW_CARD = 'yellow_card';
    const EVENT_RED_CARD = 'red_card';
    const EVENT_SUBSTITUTION = 'substitution';
    const EVENT_MATCH_START = 'match_start';
    const EVENT_MATCH_END = 'match_end';
    const EVENT_HALF_TIME = 'half_time';
    const EVENT_LIVE_UPDATE = 'live_update';

    // Relationships
    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    // Scopes
    public function scopeByFixture($query, $fixtureId)
    {
        return $query->where('fixture_id', $fixtureId);
    }

    public function scopeByEventType($query, $eventType)
    {
        return $query->where('event_type', $eventType);
    }

    public function scopeGoals($query)
    {
        return $query->where('event_type', self::EVENT_GOAL);
    }

    public function scopeCards($query)
    {
        return $query->whereIn('event_type', [self::EVENT_YELLOW_CARD, self::EVENT_RED_CARD]);
    }

    public function scopeLiveUpdates($query)
    {
        return $query->where('is_live_update', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('minute')->orderBy('sort_order');
    }

    // Accessors
    public function getFormattedMinuteAttribute()
    {
        return $this->minute ? $this->minute . "'" : null;
    }

    public function getEventIconAttribute()
    {
        return match($this->event_type) {
            self::EVENT_GOAL => '⚽',
            self::EVENT_YELLOW_CARD => '🟨',
            self::EVENT_RED_CARD => '🟥',
            self::EVENT_SUBSTITUTION => '🔄',
            default => '📝'
        };
    }

    public function getEventDisplayNameAttribute()
    {
        return match($this->event_type) {
            self::EVENT_GOAL => 'Goal',
            self::EVENT_YELLOW_CARD => 'Yellow Card',
            self::EVENT_RED_CARD => 'Red Card',
            self::EVENT_SUBSTITUTION => 'Substitution',
            self::EVENT_MATCH_START => 'Match Start',
            self::EVENT_MATCH_END => 'Match End',
            self::EVENT_HALF_TIME => 'Half Time',
            default => 'Event'
        };
    }
}
