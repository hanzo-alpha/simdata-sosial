<?php

declare(strict_types=1);

namespace App\Filament\Resources\KriteriaPpksResource\Pages;

use App\Filament\Resources\KriteriaPpksResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKriteriaPpks extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = KriteriaPpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->disabled($this->enableInputLimitDate('ppks')),
        ];
    }
}
