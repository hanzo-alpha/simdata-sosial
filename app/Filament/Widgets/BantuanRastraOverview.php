<?php

namespace App\Filament\Widgets;

use App\Enums\StatusVerifikasiEnum;
use App\Models\BantuanRastra;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class BantuanRastraOverview extends BaseWidget
{
    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        $query = BantuanRastra::query()
            ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate));

        $verified = $query->where('status_verifikasi', StatusVerifikasiEnum::VERIFIED)->count();
        $unverified = $query->where('status_verifikasi', StatusVerifikasiEnum::UNVERIFIED);
        $review = $query->where('status_verifikasi', StatusVerifikasiEnum::REVIEW)->count();

//        dd($verified);

        return [
            Stat::make(
                label: 'KPM RASTRA Tidak Terverifikasi',
                value: BantuanRastra::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('status_verifikasi', StatusVerifikasiEnum::UNVERIFIED)
                    ->count())
                ->description('Total KPM RASTRA yang belum terverifikasi')
                ->descriptionIcon('heroicon-o-document-minus')
                ->color('danger'),
            Stat::make(
                label: 'KPM RASTRA Terverifikasi',
                value: BantuanRastra::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('status_verifikasi', StatusVerifikasiEnum::VERIFIED)
                    ->count())
                ->description('Total KPM RASTRA yang sudah terverifikasi')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make(label: 'KPM RASTRA Ditinjau',
                value: BantuanRastra::query()
                    ->when($startDate, fn(Builder $builder) => $builder->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $builder) => $builder->whereDate('created_at', '<=', $endDate))
                    ->where('status_verifikasi', StatusVerifikasiEnum::REVIEW)
                    ->count())
                ->description('Total KPM RASTRA dalam proses peninjauan')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('info'),
        ];
    }
}
