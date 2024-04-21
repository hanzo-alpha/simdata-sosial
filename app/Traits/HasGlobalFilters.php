<?php

declare(strict_types=1);

namespace App\Traits;

trait HasGlobalFilters
{
    protected function getFilters(): array
    {
        return [
            'tipe' => $this->filters['tipe'] ?? null,
            'kecamatan' => $this->filters['kecamatan'] ?? null,
            'kelurahan' => $this->filters['kelurahan'] ?? null,
        ];
    }
}
