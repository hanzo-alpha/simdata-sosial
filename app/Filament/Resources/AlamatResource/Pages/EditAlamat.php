<?php

namespace App\Filament\Resources\AlamatResource\Pages;

use App\Filament\Resources\AlamatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlamat extends EditRecord
{
    protected static string $resource = AlamatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
