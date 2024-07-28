<?php

declare(strict_types=1);

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use App\Supports\Helpers;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBarangs extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = BarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->mutateFormDataUsing(function (array $data) {
                    $data['kode_barang'] ??= Helpers::generateKodeBarang();
                    return $data;
                })
                ->disabled($this->enableInputLimitDate()),
        ];
    }
}
