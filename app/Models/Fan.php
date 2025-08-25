<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Fan extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'date_of_birth',
        'gender',
        'region',
        'district',
        'ward',
        'street',
        'favorite_player_id',
        'favorite_jersey_number',
        'favorite_jersey_name',
        'favorite_jersey_type',
        'points',
        'last_login',
        'profile_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'last_login' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    /**
     * Get the point transactions for the fan.
     */
    public function pointTransactions(): HasMany
    {
        return $this->hasMany(PointTransaction::class);
    }

    /**
     * Add points to the fan with transaction tracking.
     */
    public function addPoints($points, $type = 'manual', $description = null, $metadata = null)
    {
        $this->increment('points', $points);
        
        // Create transaction record
        $this->pointTransactions()->create([
            'points' => $points,
            'type' => $type,
            'description' => $description,
            'metadata' => $metadata
        ]);
    }

    public function updateLastLogin()
    {
        $this->update(['last_login' => now()]);
    }

    public function addLoginPoints()
    {
        $this->addPoints(1, 'login', 'Daily login bonus');
        $this->updateLastLogin();
    }
    
    /**
     * Get total points earned from a specific type.
     */
    public function getPointsByType($type)
    {
        return $this->pointTransactions()->where('type', $type)->sum('points');
    }
    
    /**
     * Get recent point transactions.
     */
    public function getRecentTransactions($limit = 10)
    {
        return $this->pointTransactions()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
    

    /**
     * Get the fan's messages.
     */
    public function fanMessages(): HasMany
    {
        return $this->hasMany(FanMessage::class);
    }
}
