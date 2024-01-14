<?php

declare(strict_types=1);

namespace App\Filament\Resources\KriteriaPpksResource\Pages;

use App\Filament\Resources\KriteriaPpksResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

final class ManageKriteriaPpks extends ManageRecords
{
    protected static string $resource = KriteriaPpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
