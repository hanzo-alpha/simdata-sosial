<?php

namespace App\Filament\Resources\JenisPpksResource\Pages;

use App\Filament\Resources\JenisPpksResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageJenisPpks extends ManageRecords
{
    protected static string $resource = JenisPpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
