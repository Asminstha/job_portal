<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'plan_id','name','slug','email','phone','website','logo',
        'description','address','city','country','industry','size',
        'subscription_status','trial_ends_at','is_active',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'is_active'     => 'boolean',
    ];

    // ── Relationships ──────────────────────────────────────────
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status','active')->latestOfMany();
    }

    // ── Helpers ────────────────────────────────────────────────
    public function activePlan(): Plan
    {
        return $this->plan ?? Plan::where('slug','free')->first();
    }

    public function isOnTrial(): bool
    {
        return $this->subscription_status === 'trial'
            && $this->trial_ends_at
            && now()->lt($this->trial_ends_at);
    }

    public function trialDaysLeft(): int
    {
        if (! $this->isOnTrial()) return 0;
        return (int) now()->diffInDays($this->trial_ends_at);
    }

    public function isActive(): bool
    {
        return $this->is_active && in_array($this->subscription_status, ['trial','active']);
    }

    public function logoUrl(): string
    {
        return $this->logo
            ? asset('storage/' . $this->logo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=2563eb&color=fff&size=128';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
