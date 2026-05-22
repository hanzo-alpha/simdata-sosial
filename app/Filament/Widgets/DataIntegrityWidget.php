<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DataIntegrityWidget extends StatsOverviewWidget
{
    use \App\Traits\HasGlobalFilters;
    use \Filament\Widgets\Concerns\InteractsWithPageFilters;

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $filters = $this->getFilters();
        // helper to build per-table duplicate-NIK subquery if column exists
        $buildNikDup = function (string $table) use ($filters) {
            if (!Schema::hasColumn($table, 'nik')) {
                return null;
            }

            $query = DB::table($table)->select('nik');

            if (Schema::hasColumn($table, 'deleted_at')) {
                $query = $query->whereNull('deleted_at');
            }

            if (Schema::hasColumn($table, 'kecamatan') && ($filters['kecamatan'] ?? null)) {
                $query = $query->where('kecamatan', $filters['kecamatan']);
            }

            if (Schema::hasColumn($table, 'kelurahan') && ($filters['kelurahan'] ?? null)) {
                $query = $query->where('kelurahan', $filters['kelurahan']);
            }

            return $query->groupBy('nik')->havingRaw('COUNT(*) > 1');
        };

        $rastraDupQuery = $buildNikDup('bantuan_rastra');
        $rastraDup = $rastraDupQuery ? DB::query()->fromSub($rastraDupQuery, 'rastra_duplicates')->count() : 0;

        $ppksDupQuery = $buildNikDup('bantuan_ppks');
        $ppksDup = $ppksDupQuery ? DB::query()->fromSub($ppksDupQuery, 'ppks_duplicates')->count() : 0;

        $bpjsDupQuery = $buildNikDup('bantuan_bpjs');
        $bpjsDup = $bpjsDupQuery ? DB::query()->fromSub($bpjsDupQuery, 'bpjs_duplicates')->count() : 0;

        // Cross-table duplicates (e.g. NIK in Rastra and PPKS)
        $subqueries = [];
        foreach (['bantuan_rastra', 'bantuan_ppks', 'bantuan_bpjs'] as $tbl) {
            $q = $buildNikDup($tbl);
            if ($q) {
                $subqueries[] = $q;
            }
        }

        if (empty($subqueries)) {
            $crossDupCount = 0;
        } else {
            $union = array_shift($subqueries);
            foreach ($subqueries as $sq) {
                $union = $union->unionAll($sq);
            }

            $crossDupCountQuery = DB::query()->fromSub($union, 'all_niks')
                ->select('nik')
                ->groupBy('nik')
                ->havingRaw('COUNT(*) > 1');

            $crossDupCount = DB::query()->fromSub($crossDupCountQuery, 'cross_duplicates')->count();
        }

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
