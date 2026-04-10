<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategory extends Model
{
    protected $fillable = ['parent_id','name','slug','icon','is_active','sort_order'];

    protected $casts = ['is_active' => 'boolean'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(JobCategory::class, 'parent_id');
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'category_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
