<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'company_id','name','email','password',
        'role','avatar','phone','is_active',
    ];

    protected $hidden = ['password','remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active'         => 'boolean',
        'password'          => 'hashed',
    ];

    // ── Relationships ──────────────────────────────────────────
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function seekerProfile(): HasOne
    {
        return $this->hasOne(SeekerProfile::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function savedJobs(): HasMany
    {
        return $this->hasMany(SavedJob::class);
    }

    // ── Role helpers ───────────────────────────────────────────
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCompanyAdmin(): bool
    {
        return $this->role === 'company_admin';
    }

    public function isRecruiter(): bool
    {
        return $this->role === 'recruiter';
    }

    public function isSeeker(): bool
    {
        return $this->role === 'seeker';
    }

    public function isCompanyMember(): bool
    {
        return in_array($this->role, ['company_admin', 'recruiter']);
    }

    // ── Helpers ────────────────────────────────────────────────
   public function avatarUrl(): string
{
    return $this->avatar
        ? asset('storage/' . $this->avatar)
        : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=7c3aed&color=fff&size=128';
}
    public function dashboardRoute(): string
    {
        return match($this->role) {
            'admin'                    => route('admin.dashboard'),
            'company_admin','recruiter'=> route('company.dashboard'),
            default                    => route('seeker.dashboard'),
        };
    }
}
