<?php

namespace App\Filament\Resources\AlamatResource\Pages;

use App\Filament\Resources\AlamatResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAlamat extends CreateRecord
{
    protected static string $resource = AlamatResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['provinsi'] = '73';
        $data['kabupaten'] = '7312';
//        $data['no_rt'] = 001;
//        $data['no_rw'] = 002;
//        $data['dusun'] = 'Dusun Lebbae';
        return $data;
    }
}
