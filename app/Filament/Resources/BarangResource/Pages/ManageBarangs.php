<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use App\Supports\Helpers;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBarangs extends ManageRecords
{
    protected static string $resource = BarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->mutateFormDataUsing(function (array $data) {
                    $data['kode_barang'] ??= Helpers::generateKodeBarang();
                    return $data;
                }),
        ];
    }
}
