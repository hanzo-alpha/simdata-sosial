<?php

namespace App\Filament\Resources\BantuanBpjsResource\Pages;

use App\Filament\Resources\BantuanBpjsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBantuanBpjs extends ListRecords
{
    protected static string $resource = BantuanBpjsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
