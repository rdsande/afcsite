<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'logo',
        'home_stadium',
        'founded_year',
        'description',
        'website',
        'social_media',
        'primary_color',
        'secondary_color',
        'is_active'
    ];

    protected $casts = [
        'founded_year' => 'integer',
        'social_media' => 'array',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function homeFixtures()
    {
        return $this->hasMany(Fixture::class, 'home_team_id');
    }

    public function awayFixtures()
    {
        return $this->hasMany(Fixture::class, 'away_team_id');
    }

    public function allFixtures()
    {
        return $this->homeFixtures()->union($this->awayFixtures());
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    // Accessors
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('img/teamlogos/default.png');
    }
}
