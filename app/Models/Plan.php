<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'name','slug','description','price_monthly','price_yearly',
        'max_jobs','max_recruiters','featured_jobs_allowed',
        'has_analytics','has_ats','is_active','sort_order',
    ];

    protected $casts = [
        'featured_jobs_allowed' => 'boolean',
        'has_analytics'         => 'boolean',
        'has_ats'               => 'boolean',
        'is_active'             => 'boolean',
    ];

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    public function isFree(): bool
    {
        return $this->price_monthly === 0;
    }

    public function yearlyDiscount(): int
    {
        if ($this->price_monthly === 0) return 0;
        $monthlyCost = $this->price_monthly * 12;
        return (int) round((($monthlyCost - $this->price_yearly) / $monthlyCost) * 100);
    }
}
