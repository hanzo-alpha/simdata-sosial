<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanRastraResource\Pages;

use App\Filament\Resources\BantuanRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditBantuanRastra extends EditRecord
{
    protected static string $resource = BantuanRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
