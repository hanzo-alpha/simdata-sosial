<?php

namespace App\Filament\Resources\KeluargaResource\Pages;

use App\Filament\Resources\KeluargaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKeluarga extends CreateRecord
{
    protected static string $resource = KeluargaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['alamat_id'] = 1;
        $data['provinsi'] = '73';
        $data['kabupaten'] = '7312';
        $data['no_rt'] = 001;
        $data['no_rw'] = 002;
        $data['dusun'] = 'Dusun Laloa';
        return $data;
    }
}
