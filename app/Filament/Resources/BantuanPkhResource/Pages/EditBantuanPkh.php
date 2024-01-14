<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPkhResource\Pages;

use App\Filament\Resources\BantuanPkhResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditBantuanPkh extends EditRecord
{
    protected static string $resource = BantuanPkhResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
