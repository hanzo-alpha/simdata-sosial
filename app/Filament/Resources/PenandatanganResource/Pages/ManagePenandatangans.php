<?php

namespace App\Filament\Resources\PenandatanganResource\Pages;

use App\Filament\Imports\PenandatanganImporter;
use App\Filament\Resources\PenandatanganResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePenandatangans extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = PenandatanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->label('Import Penandatangan')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->disabled($this->enableInputLimitDate())
                ->importer(PenandatanganImporter::class),
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->disabled($this->enableInputLimitDate()),
        ];
    }
}
