<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPpksResource\Pages;

use App\Filament\Resources\BantuanPpksResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewBantuanPpks extends ViewRecord
{
    protected static string $resource = BantuanPpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
