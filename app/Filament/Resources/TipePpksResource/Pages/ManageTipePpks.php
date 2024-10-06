<?php

declare(strict_types=1);

namespace App\Filament\Resources\TipePpksResource\Pages;

use App\Filament\Resources\TipePpksResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTipePpks extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = TipePpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->disabled($this->enableInputLimitDate('ppks'))
                ->closeModalByClickingAway(),
        ];
    }
}
