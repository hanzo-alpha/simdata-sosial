<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanBpntResource\Pages;

use App\Filament\Resources\BantuanBpntResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBantuanBpnt extends ViewRecord
{
    use HasInputDateLimit;

    protected static string $resource = BantuanBpntResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->disabled($this->enableInputLimitDate('bpnt'))
        ];
    }
}
