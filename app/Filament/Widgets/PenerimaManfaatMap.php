<?php

namespace App\Filament\Widgets;

use App\Models\Keluarga;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Cheesegrits\FilamentGoogleMaps\Actions\GoToAction;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Cheesegrits\FilamentGoogleMaps\Filters\MapIsFilter;
use Cheesegrits\FilamentGoogleMaps\Widgets\MapTableWidget;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class PenerimaManfaatMap extends MapTableWidget
{
    use HasWidgetShield;

    protected static ?string $heading = 'Keluarga Map';

    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = null;

    protected static ?bool $clustering = true;

    protected static ?string $mapId = 'incidents';

    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Keluarga::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('dtks_id')
                ->label('DTKS ID'),
            Tables\Columns\TextColumn::make('nik'),
            Tables\Columns\TextColumn::make('nokk'),
            Tables\Columns\TextColumn::make('nama_lengkap'),
            Tables\Columns\TextColumn::make('alamat_penerima'),
            Tables\Columns\TextColumn::make('latitude'),
            Tables\Columns\TextColumn::make('longitude'),
            MapColumn::make('location')
                ->extraImgAttributes(
                    fn($record): array => ['title' => $record->latitude . ',' . $record->longitude]
                )
                ->height('150')
                ->width('250')
                ->type('hybrid')
                ->zoom(15),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
//			RadiusFilter::make('location')
//				->section('Radius Filter')
//				->selectUnit(),
            MapIsFilter::make('map'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            GoToAction::make()
                ->zoom(14),
//			RadiusAction::make(),
        ];
    }

    protected function getData(): array
    {
        $locations = $this->getRecords();

        $data = [];

        foreach ($locations as $location) {
            $data[] = [
                'location' => [
                    'lat' => $location->latitude ? round(floatval($location->latitude), static::$precision) : 0,
                    'lng' => $location->longitude ? round(floatval($location->longitude), static::$precision) : 0,
                ],
                'id' => $location->id,
            ];
        }

        return $data;
    }
}
