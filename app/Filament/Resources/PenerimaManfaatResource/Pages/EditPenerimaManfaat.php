<?php

namespace App\Filament\Resources\PenerimaManfaatResource\Pages;

use App\Filament\Resources\PenerimaManfaatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenerimaManfaat extends EditRecord
{
    protected static string $resource = PenerimaManfaatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
