<?php

declare(strict_types=1);

namespace App\Filament\Resources\JenisPsksResource\Pages;

use App\Filament\Resources\JenisPsksResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageJenisPsks extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = JenisPsksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->disabled($this->enableInputLimitDate())
                ->icon('heroicon-o-plus'),
        ];
    }
}
