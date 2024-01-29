<?php

namespace App\Filament\Widgets;

use App\Enums\StatusDtksEnum;
use App\Models\BnbaRastra;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Number;

class BnbaRastraOverview extends BaseWidget
{
    use HasWidgetShield;

    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        $query = static::getQuery($this->getFilter());
        $all = $query->count();
        $dtks = $query->statusDtks(StatusDtksEnum::DTKS)->count();
        $nonDtks = $all - $dtks;

        return [
            Stat::make(
                label: 'KPM BNBA RASTRA',
                value: Number::abbreviate($all, 2)
            )
                ->description('Total Seluruh KPM BNBA RASTRA')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
            Stat::make(
                label: 'KPM RASTRA TERDAFTAR DTKS',
                value: Number::abbreviate($dtks, 2)
            )
                ->description('Jumlah KPM RASTRA Terdaftar DTKS')
                ->descriptionIcon('heroicon-o-user-minus')
                ->color('success'),
            Stat::make(
                label: 'KPM RASTRA NON DTKS',
                value: Number::abbreviate($nonDtks, 2)
            )
                ->description('Jumlah KPM RASTRA NON DTKS')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('danger'),
        ];
    }

    protected static function getQuery(array $filter): Builder
    {
        return BnbaRastra::query()
            ->when($filter['dateRange'], function (Builder $query) use ($filter) {
                $dates = explode('-', $filter['dateRange']);

                return $query
                    ->whereDate('created_at', '>=', $dates[0])
                    ->whereDate('created_at', '<=', $dates[1]);
            })
            ->when($filter['kecamatan'], fn(Builder $query) => $query->whereHas(
                'alamat',
                fn(Builder $query) => $query->whereHas(
                    'kec',
                    fn(Builder $query) => $query->where('code', $filter['kecamatan'])
                )
            ))
            ->when($filter['kelurahan'], fn(Builder $query) => $query->whereHas(
                'alamat',
                fn(Builder $query) => $query->whereHas(
                    'kel',
                    fn(Builder $query) => $query->where('code', $filter['kelurahan'])
                )
            ));
    }

    protected function getFilter(): array
    {
        return [
            'dateRange' => $this->filters['daterange'] ?? null,
            'kecamatan' => $this->filters['kecamatan'] ?? null,
            'kelurahan' => $this->filters['kelurahan'] ?? null,
        ];
    }
}
