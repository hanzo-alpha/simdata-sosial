<?php

declare(strict_types=1);

namespace App\Filament\Resources\PenyaluranBantuanRastraResource\Pages;

use App\Filament\Resources\PenyaluranBantuanRastraResource;
use Filament\Resources\Pages\CreateRecord;

final class CreatePenyaluranBantuanRastra extends CreateRecord
{
    protected static string $resource = PenyaluranBantuanRastraResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Penyaluran Rastra berhasil disimpan';
    }
}
