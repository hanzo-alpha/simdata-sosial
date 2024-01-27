<?php

namespace App\Filament\Resources\PenyaluranBantuanPpksResource\Pages;

use App\Filament\Resources\PenyaluranBantuanPpksResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenyaluranBantuanPpks extends EditRecord
{
    protected static string $resource = PenyaluranBantuanPpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
