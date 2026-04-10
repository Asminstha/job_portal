<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'job_id','user_id','company_id','cover_letter','resume_path',
        'status','status_changed_at','rejection_reason','notes','read_at',
    ];

    protected $casts = [
        'status_changed_at' => 'datetime',
        'read_at'           => 'datetime',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ApplicationStatusHistory::class);
    }

    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class);
    }

    public function statusBadgeClass(): string
    {
        return match($this->status) {
            'pending'     => 'badge-yellow',
            'reviewed'    => 'badge-blue',
            'shortlisted' => 'badge-purple',
            'interview'   => 'badge-blue',
            'offered'     => 'badge-green',
            'hired'       => 'badge-green',
            'rejected'    => 'badge-red',
            'withdrawn'   => 'badge-gray',
            default       => 'badge-gray',
        };
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'pending'     => 'Pending Review',
            'reviewed'    => 'Under Review',
            'shortlisted' => 'Shortlisted',
            'interview'   => 'Interview',
            'offered'     => 'Offer Extended',
            'hired'       => 'Hired',
            'rejected'    => 'Not Selected',
            'withdrawn'   => 'Withdrawn',
            default       => ucfirst($this->status),
        };
    }
}
