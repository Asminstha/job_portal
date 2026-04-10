<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interview extends Model
{
    protected $fillable = [
        'application_id','company_id','scheduled_by','interview_type',
        'scheduled_at','duration_minutes','location_or_link','notes','status',
    ];

    protected $casts = ['scheduled_at' => 'datetime'];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scheduledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'scheduled_by');
    }
}
