<?php

declare(strict_types=1);

namespace App\Filament\Resources\TipePpksResource\Pages;

use App\Filament\Resources\TipePpksResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

final class ManageTipePpks extends ManageRecords
{
    protected static string $resource = TipePpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus'),
        ];
    }
}
