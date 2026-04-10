<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToCompany
{
    protected static function bootBelongsToCompany(): void
    {
        // Auto-set company_id when creating a record
        static::creating(function ($model) {
            if (
                auth()->check() &&
                auth()->user()->company_id &&
                empty($model->company_id)
            ) {
                $model->company_id = auth()->user()->company_id;
            }
        });

        // Auto-scope all queries to current company (not for admin)
        static::addGlobalScope('company', function (Builder $builder) {
            if (
                auth()->check() &&
                auth()->user()->company_id &&
                ! auth()->user()->isAdmin()
            ) {
                $table = $builder->getModel()->getTable();
                $builder->where("{$table}.company_id", auth()->user()->company_id);
            }
        });
    }
}
