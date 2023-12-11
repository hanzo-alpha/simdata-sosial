<?php

namespace App\Filament\Resources\UsulanPengaktifanTmtResource\Pages;

use App\Filament\Resources\UsulanPengaktifanTmtResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUsulanPengaktifanTmt extends EditRecord
{
    protected static string $resource = UsulanPengaktifanTmtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
