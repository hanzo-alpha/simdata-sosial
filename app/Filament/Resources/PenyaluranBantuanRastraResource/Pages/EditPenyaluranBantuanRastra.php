<?php

declare(strict_types=1);

namespace App\Filament\Resources\PenyaluranBantuanRastraResource\Pages;

use App\Filament\Resources\PenyaluranBantuanRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditPenyaluranBantuanRastra extends EditRecord
{
    protected static string $resource = PenyaluranBantuanRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
