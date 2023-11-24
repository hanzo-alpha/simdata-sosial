<?php

namespace App\Filament\Resources\BantuanPkhBpntResource\Pages;

use App\Filament\Resources\BantuanPkhBpntResource;
use App\Imports\BantuanPkhBpntImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBantuanPkhBpnt extends ManageRecords
{
    protected static string $resource = BantuanPkhBpntResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Impor Data')
                ->modalHeading('Impor Data Bantuan PKH Atau BPNT')
                ->after(function (array $data) {
                    dd($data);
                    $import = \Maatwebsite\Excel\Facades\Excel::import(new BantuanPkhBpntImport, $data['attachment'],
                        'public');
                }),
            ExcelImportAction::make()
                ->use(BantuanPkhBpntImport::class, Actions\CreateAction::make())
        ];
    }
}
