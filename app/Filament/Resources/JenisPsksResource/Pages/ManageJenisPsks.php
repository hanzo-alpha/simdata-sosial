<?php

namespace App\Filament\Resources\JenisPsksResource\Pages;

use App\Filament\Resources\JenisPsksResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageJenisPsks extends ManageRecords
{
    protected static string $resource = JenisPsksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
