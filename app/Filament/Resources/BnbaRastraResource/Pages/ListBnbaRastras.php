<?php

namespace App\Filament\Resources\BnbaRastraResource\Pages;

use App\Enums\StatusDtksEnum;
use App\Filament\Imports\BnbaRastraImporter;
use App\Filament\Resources\BnbaRastraResource;
use App\Filament\Widgets\BnbaRastraOverview;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBnbaRastras extends ListRecords
{
    protected static string $resource = BnbaRastraResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'DTKS' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->statusDtks(StatusDtksEnum::DTKS)),
            'NON DTKS' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->statusDtks(StatusDtksEnum::NON_DTKS)),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            //            Actions\ExportAction::make()
            //                ->label('Ekspor BNBA')
            //                ->exporter(BnbaRastraExporter::class)
            //                ->color('info')
            //                ->icon('heroicon-o-arrow-down-tray'),
            Actions\ImportAction::make()
                ->label('Impor BNBA')
                ->importer(BnbaRastraImporter::class)
                ->options(['updateExisting' => true])
                ->maxRows(10000)
                ->chunkSize(200)
                ->csvDelimiter(';')
                ->color('success')
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make()
                ->color('primary')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BnbaRastraOverview::class,
        ];
    }
}
