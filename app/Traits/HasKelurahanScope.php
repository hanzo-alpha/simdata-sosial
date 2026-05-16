<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Scopes\KelurahanScope;

trait HasKelurahanScope
{
    public static function bootHasKelurahanScope(): void
    {
        static::addGlobalScope(new KelurahanScope());
    }
}
