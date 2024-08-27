<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPkhResource\Pages;

use App\Filament\Resources\BantuanPkhResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewBantuanPkh extends ViewRecord
{
    use HasInputDateLimit;

    protected static string $resource = BantuanPkhResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->disabled($this->enableInputLimitDate('pkh')),
        ];
    }
}
