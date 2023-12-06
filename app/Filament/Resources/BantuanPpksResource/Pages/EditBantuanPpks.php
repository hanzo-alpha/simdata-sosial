<?php

namespace App\Filament\Resources\BantuanPpksResource\Pages;

use App\Filament\Resources\BantuanPpksResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBantuanPpks extends EditRecord
{
    protected static string $resource = BantuanPpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
