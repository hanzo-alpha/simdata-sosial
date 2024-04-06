<?php

namespace App\Filament\Resources\PenandatanganResource\Pages;

use App\Filament\Imports\PenandatanganImporter;
use App\Filament\Resources\PenandatanganResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePenandatangans extends ManageRecords
{
    protected static string $resource = PenandatanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->label('Import Penandatangan')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->importer(PenandatanganImporter::class),
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->disabled(cek_batas_input(setting('app.batas_tgl_input'))),
        ];
    }
}
