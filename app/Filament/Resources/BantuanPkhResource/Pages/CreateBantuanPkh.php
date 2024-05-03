<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPkhResource\Pages;

use App\Filament\Resources\BantuanPkhResource;
use Filament\Resources\Pages\CreateRecord;
use Str;

final class CreateBantuanPkh extends CreateRecord
{
    protected static string $resource = BantuanPkhResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['kode_wilayah'] = $data['kelurahan'];
        $data['dtks_id'] = Str::orderedUuid()->toString();
        return $data;
    }
}
