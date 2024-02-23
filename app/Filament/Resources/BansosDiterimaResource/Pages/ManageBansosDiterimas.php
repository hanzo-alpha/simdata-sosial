<?php

namespace App\Filament\Resources\BansosDiterimaResource\Pages;

use App\Filament\Resources\BansosDiterimaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBansosDiterimas extends ManageRecords
{
    protected static string $resource = BansosDiterimaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
