<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeekerProfile extends Model
{
    protected $fillable = [
        'user_id','headline','summary','location','experience_years',
        'current_salary','expected_salary','notice_period_days',
        'resume_path','linkedin_url','portfolio_url','github_url',
        'skills','languages','availability',
    ];

    protected $casts = [
        'skills'    => 'array',
        'languages' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resumeUrl(): ?string
    {
        return $this->resume_path ? asset('storage/' . $this->resume_path) : null;
    }
}
