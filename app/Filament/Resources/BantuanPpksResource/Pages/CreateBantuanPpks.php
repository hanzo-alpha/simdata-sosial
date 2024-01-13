<?php

namespace App\Filament\Resources\BantuanPpksResource\Pages;

use App\Filament\Resources\BantuanPpksResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBantuanPpks extends CreateRecord
{
    protected static string $resource = BantuanPpksResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['dtks_id'] = $data['dtks_id'] ?? \Str::uuid()->toString();
        $data['jenis_bantuan_id'] = $data['jenis_bantuan_id'] ?? 4;

        return $data;
    }
}
