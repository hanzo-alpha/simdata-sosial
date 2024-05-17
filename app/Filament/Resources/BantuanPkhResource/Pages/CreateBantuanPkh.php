<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPkhResource\Pages;

use App\Enums\StatusDtksEnum;
use App\Enums\StatusPkhBpntEnum;
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
        $data['jenis_bantuan_id'] = 1;
        $data['status_dtks'] ??= StatusDtksEnum::DTKS;
        $data['status_pkh'] ??= StatusPkhBpntEnum::PKH;
        return $data;
    }
}
