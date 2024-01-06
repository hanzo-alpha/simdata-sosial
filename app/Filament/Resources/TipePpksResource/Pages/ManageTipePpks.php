<?php

namespace App\Filament\Resources\TipePpksResource\Pages;

use App\Filament\Resources\TipePpksResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTipePpks extends ManageRecords
{
    protected static string $resource = TipePpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
