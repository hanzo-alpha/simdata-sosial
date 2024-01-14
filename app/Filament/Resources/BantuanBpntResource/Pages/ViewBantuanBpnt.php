<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanBpntResource\Pages;

use App\Filament\Resources\BantuanBpntResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewBantuanBpnt extends ViewRecord
{
    protected static string $resource = BantuanBpntResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
