<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPpksResource\Pages;

use App\Enums\StatusAktif;
use App\Filament\Resources\BantuanPpksResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateBantuanPpks extends CreateRecord
{
    protected static string $resource = BantuanPpksResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['jenis_bantuan_id'] = 4;
        $data['status_aktif'] ??= StatusAktif::AKTIF;

        return $data;
    }
}
