<?php

declare(strict_types=1);

namespace App\Filament\Resources\PenggantiRastraResource\Pages;

use App\Filament\Resources\PenggantiRastraResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePenggantiRastra extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = PenggantiRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->disabled($this->enableInputLimitDate()),
        ];
    }
}
