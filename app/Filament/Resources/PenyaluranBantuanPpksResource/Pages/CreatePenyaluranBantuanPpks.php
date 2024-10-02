<?php

declare(strict_types=1);

namespace App\Filament\Resources\PenyaluranBantuanPpksResource\Pages;

use App\Filament\Resources\PenyaluranBantuanPpksResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePenyaluranBantuanPpks extends CreateRecord
{
    protected static string $resource = PenyaluranBantuanPpksResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Penyaluran PPKS berhasil disimpan';
    }
}
