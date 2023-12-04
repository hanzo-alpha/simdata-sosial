<?php

namespace App\Filament\Resources\BantuanResource\Pages;

use App\Filament\Resources\BantuanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBantuan extends EditRecord
{
    protected static string $resource = BantuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
