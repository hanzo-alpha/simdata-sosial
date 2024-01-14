<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanBpjsResource\Pages;

use App\Filament\Resources\BantuanBpjsResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewBantuanBpjs extends ViewRecord
{
    protected static string $resource = BantuanBpjsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
