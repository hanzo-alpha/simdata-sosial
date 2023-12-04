<?php

namespace App\Filament\Resources\PenerimaManfaatResource\Pages;

use App\Filament\Resources\PenerimaManfaatResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPenerimaManfaat extends ViewRecord
{
    protected static string $resource = PenerimaManfaatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
