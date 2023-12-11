<?php

namespace App\Filament\Resources\JenisDisabilitasResource\Pages;

use App\Filament\Resources\JenisDisabilitasResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageJenisDisabilitas extends ManageRecords
{
    protected static string $resource = JenisDisabilitasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
