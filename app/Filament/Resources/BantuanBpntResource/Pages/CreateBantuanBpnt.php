<?php

namespace App\Filament\Resources\BantuanBpntResource\Pages;

use App\Filament\Resources\BantuanBpntResource;
use Filament\Resources\Pages\CreateRecord;
use Str;

class CreateBantuanBpnt extends CreateRecord
{
    protected static string $resource = BantuanBpntResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['jenis_bantuan_id'] = 2;

        return $data;
    }
}
