<?php

declare(strict_types=1);

namespace App\Traits;

trait HasGlobalFilters
{
    public function getFilters(): array
    {
        $pageFilters = (array) ($this->filters ?? []);

        $filters = [
            'tipe' => $pageFilters['tipe'] ?? null,
            'kecamatan' => $pageFilters['kecamatan'] ?? null,
            'kelurahan' => $pageFilters['kelurahan'] ?? null,
            'tahun' => $pageFilters['tahun'] ?? 2024,
        ];

        if (auth()->check() && auth()->user()->instansi_id) {
            $filters['kelurahan'] = auth()->user()->instansi_id;
            $filters['kecamatan'] = auth()->user()->instansi?->kecamatan_code;
        }

        return $filters;
    }
}
