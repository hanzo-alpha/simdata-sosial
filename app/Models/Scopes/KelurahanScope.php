<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class KelurahanScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (auth()->check() && ! auth()->user()->hasRole(superadmin_admin_roles())) {
            $column = method_exists($model, 'getKelurahanColumn') ? $model->getKelurahanColumn() : 'kelurahan';
            $builder->where($model->getTable() . '.' . $column, auth()->user()->instansi_id);
        }
    }
}
