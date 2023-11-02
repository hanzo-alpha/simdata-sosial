<?php

namespace App\Filament\Resources\JenisPelayananResource\Pages;

use App\Filament\Resources\JenisPelayananResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageJenisPelayanans extends ManageRecords
{
    protected static string $resource = JenisPelayananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
