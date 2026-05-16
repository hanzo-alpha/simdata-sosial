<?php

declare(strict_types=1);

namespace App\Traits;

trait HasGlobalFilters
{
    public function getFilters(): array
    {
        $filters = [
            'tipe' => $this->pageFilters['tipe'] ?? null,
            'kecamatan' => $this->pageFilters['kecamatan'] ?? null,
            'kelurahan' => $this->pageFilters['kelurahan'] ?? null,
        ];

        if (auth()->check() && auth()->user()->instansi_id) {
            $filters['kelurahan'] = auth()->user()->instansi_id;
            $filters['kecamatan'] = auth()->user()->instansi?->kecamatan_code;
        }

        return $filters;
    }
}
