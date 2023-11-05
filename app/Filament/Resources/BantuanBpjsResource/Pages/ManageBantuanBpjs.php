<?php

namespace App\Filament\Resources\BantuanBpjsResource\Pages;

use App\Filament\Resources\BantuanBpjsResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBantuanBpjs extends ManageRecords
{
    protected static string $resource = BantuanBpjsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
