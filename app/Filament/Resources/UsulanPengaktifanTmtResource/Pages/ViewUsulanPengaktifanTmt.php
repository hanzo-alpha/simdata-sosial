<?php

namespace App\Filament\Resources\UsulanPengaktifanTmtResource\Pages;

use App\Filament\Resources\UsulanPengaktifanTmtResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUsulanPengaktifanTmt extends ViewRecord
{
    protected static string $resource = UsulanPengaktifanTmtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
