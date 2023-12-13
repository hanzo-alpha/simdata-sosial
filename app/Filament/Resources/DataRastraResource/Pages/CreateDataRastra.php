<?php

namespace App\Filament\Resources\DataRastraResource\Pages;

use App\Filament\Resources\DataRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDataRastra extends CreateRecord
{
    protected static string $resource = DataRastraResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['dtks_id'] = $data['dtks_id'] ?? \Str::uuid()->toString();
        $data['jenis_bantuan_id'] = 5;
        $data['tgl_penyerahan'] = $data['tgl_penyerahan'] ?? now();
        $data['lokasi_map'] = $data['location'];
        return $data;
    }
}
