<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanBpjsResource\Pages;

use App\Filament\Resources\BantuanBpjsResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBantuanBpjs extends ViewRecord
{
    use HasInputDateLimit;

    protected static string $resource = BantuanBpjsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->disabled($this->enableInputLimitDate('bpjs')),
        ];
    }
}
