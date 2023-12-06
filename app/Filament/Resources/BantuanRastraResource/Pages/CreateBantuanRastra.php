<?php

namespace App\Filament\Resources\BantuanRastraResource\Pages;

use App\Filament\Resources\BantuanRastraResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBantuanRastra extends CreateRecord
{
    protected static string $resource = BantuanRastraResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['location'] = null;
        $data['dtks_id'] = $data['dtks_id'] ?? \Str::uuid()->toString();
        return $data;
    }
}
