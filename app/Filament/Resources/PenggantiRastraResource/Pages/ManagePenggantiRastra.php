<?php

declare(strict_types=1);

namespace App\Filament\Resources\PenggantiRastraResource\Pages;

use App\Filament\Resources\PenggantiRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

final class ManagePenggantiRastra extends ManageRecords
{
    protected static string $resource = PenggantiRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
