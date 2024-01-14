<?php

declare(strict_types=1);

namespace App\Filament\Resources\JenisBantuanResource\Pages;

use App\Filament\Resources\JenisBantuanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

final class ManageJenisBantuan extends ManageRecords
{
    protected static string $resource = JenisBantuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
