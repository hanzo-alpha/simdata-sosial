<?php

namespace App\Filament\Resources\BantuanBpjsResource\Pages;

use App\Filament\Resources\BantuanBpjsResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBantuanBpjs extends ViewRecord
{
    protected static string $resource = BantuanBpjsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
