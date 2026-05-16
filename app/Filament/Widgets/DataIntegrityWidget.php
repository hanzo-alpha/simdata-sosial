<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class DataIntegrityWidget extends StatsOverviewWidget
{
    use \App\Traits\HasGlobalFilters;
    use \Filament\Widgets\Concerns\InteractsWithPageFilters;

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $filters = $this->getFilters();

        $rastraDup = DB::table('bantuan_rastra')
            ->select('nik')
            ->whereNull('deleted_at')
            ->when($filters['kecamatan'] ?? null, fn($q, $val) => $q->where('kecamatan', $val))
            ->when($filters['kelurahan'] ?? null, fn($q, $val) => $q->where('kelurahan', $val))
            ->groupBy('nik')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();

        $ppksDup = DB::table('bantuan_ppks')
            ->select('nik')
            ->whereNull('deleted_at')
            ->when($filters['kecamatan'] ?? null, fn($q, $val) => $q->where('kecamatan', $val))
            ->when($filters['kelurahan'] ?? null, fn($q, $val) => $q->where('kelurahan', $val))
            ->groupBy('nik')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();

        $bpjsDup = DB::table('bantuan_bpjs')
            ->select('nik')
            ->whereNull('deleted_at')
            ->when($filters['kecamatan'] ?? null, fn($q, $val) => $q->where('kecamatan', $val))
            ->when($filters['kelurahan'] ?? null, fn($q, $val) => $q->where('kelurahan', $val))
            ->groupBy('nik')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();

        // Cross-table duplicates (e.g. NIK in Rastra and PPKS)
        $crossDupCount = DB::table(DB::raw("(
            SELECT nik FROM bantuan_rastra WHERE deleted_at IS NULL " . ($filters['kecamatan'] ? " AND kecamatan = '{$filters['kecamatan']}'" : "") . ($filters['kelurahan'] ? " AND kelurahan = '{$filters['kelurahan']}'" : "") . "
            UNION ALL
            SELECT nik FROM bantuan_ppks WHERE deleted_at IS NULL " . ($filters['kecamatan'] ? " AND kecamatan = '{$filters['kecamatan']}'" : "") . ($filters['kelurahan'] ? " AND kelurahan = '{$filters['kelurahan']}'" : "") . "
            UNION ALL
            SELECT nik FROM bantuan_bpjs WHERE deleted_at IS NULL " . ($filters['kecamatan'] ? " AND kecamatan = '{$filters['kecamatan']}'" : "") . ($filters['kelurahan'] ? " AND kelurahan = '{$filters['kelurahan']}'" : "") . "
        ) as all_niks"))
            ->select('nik')
            ->groupBy('nik')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();

        return [
            Stat::make('Duplikasi NIK Rastra', $rastraDup)
                ->description('Jumlah NIK ganda di tabel Rastra')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($rastraDup > 0 ? 'danger' : 'success'),
            Stat::make('Duplikasi NIK PPKS', $ppksDup)
                ->description('Jumlah NIK ganda di tabel PPKS')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($ppksDup > 0 ? 'danger' : 'success'),
            Stat::make('Duplikasi NIK BPJS', $bpjsDup)
                ->description('Jumlah NIK ganda di tabel BPJS')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($bpjsDup > 0 ? 'danger' : 'success'),
            Stat::make('Duplikasi Lintas Bansos', $crossDupCount)
                ->description('NIK terdaftar di >1 jenis bantuan')
                ->descriptionIcon('heroicon-m-arrows-right-left')
                ->color($crossDupCount > 0 ? 'warning' : 'success'),
        ];
    }
}
