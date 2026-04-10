<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Job extends Model
{
    use BelongsToCompany;

    protected $table = 'job_listings';
    protected $fillable = [
        'company_id','created_by','category_id','title','slug',
        'description','requirements','benefits','type','location_type',
        'city','country','salary_min','salary_max','salary_currency',
        'salary_period','salary_hidden','experience_min','experience_max',
        'status','is_featured','featured_until','expires_at','published_at',
    ];

    protected $casts = [
        'is_featured'   => 'boolean',
        'salary_hidden' => 'boolean',
        'featured_until'=> 'datetime',
        'expires_at'    => 'datetime',
        'published_at'  => 'datetime',
    ];

    // ── Auto-generate slug ─────────────────────────────────────
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($job) {
            if (empty($job->slug)) {
                $job->slug = static::generateSlug($job->title);
            }
        });
    }

    public static function generateSlug(string $title): string
    {
        $base  = Str::slug($title);
        $slug  = $base;
        $count = 1;
        while (static::withoutGlobalScopes()->where('slug', $slug)->exists()) {
            $slug = $base . '-' . $count++;
        }
        return $slug;
    }

    // ── Relationships ──────────────────────────────────────────
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function savedByUsers(): HasMany
    {
        return $this->hasMany(SavedJob::class);
    }

    // ── Scopes ─────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where(fn($q) => $q->whereNull('expires_at')
                                         ->orWhere('expires_at', '>', now()));
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                     ->where('featured_until', '>', now());
    }

    // ── Helpers ────────────────────────────────────────────────
    public function salaryDisplay(): string
    {
        if ($this->salary_hidden) return 'Negotiable';
        if (! $this->salary_min)  return 'Not specified';

        $min = number_format($this->salary_min);
        $max = $this->salary_max ? number_format($this->salary_max) : null;

        $range = $max ? "{$this->salary_currency} {$min} – {$max}" : "{$this->salary_currency} {$min}+";
        return $range . ' / ' . $this->salary_period;
    }

    public function typeLabel(): string
    {
        return match($this->type) {
            'full_time'  => 'Full Time',
            'part_time'  => 'Part Time',
            'contract'   => 'Contract',
            'internship' => 'Internship',
            'freelance'  => 'Freelance',
            default      => ucfirst($this->type),
        };
    }

    public function locationLabel(): string
    {
        return match($this->location_type) {
            'remote'  => 'Remote',
            'hybrid'  => 'Hybrid',
            'onsite'  => $this->city ?? 'On-site',
            default   => ucfirst($this->location_type),
        };
    }

    public function isExpired(): bool
    {
        return $this->expires_at && now()->gt($this->expires_at);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
