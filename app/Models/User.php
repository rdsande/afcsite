<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime'
    ];

    // Relationships
    public function news()
    {
        return $this->hasMany(News::class, 'author_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeAdmins($query)
    {
        return $query->whereIn('role', ['admin', 'super_admin']);
    }

    public function scopeEditors($query)
    {
        return $query->where('role', 'editor');
    }

    // Role checking methods
    /**
     * Check if user is super admin
     */
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    /**
     * Check if user is editor
     */
    public function isEditor()
    {
        return $this->role === 'editor';
    }

    /**
     * Check if user has specific role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Check if user can manage users
     */
    public function canManageUsers()
    {
        return $this->isSuperAdmin();
    }

    /**
     * Check if user can manage content
     */
    public function canManageContent()
    {
        return $this->isAdmin() || $this->isEditor();
    }

    /**
     * Check if user can publish content
     */
    public function canPublishContent()
    {
        return $this->isAdmin();
    }

    // Helper methods
    /**
     * Update user's last login timestamp
     */
    public function updateLastLogin()
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Activate user account
     */
    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    /**
     * Deactivate user account
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->role));
    }
}
