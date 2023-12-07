<?php

namespace App\Filament\Resources\BantuanPkhResource\Pages;

use App\Filament\Resources\BantuanPkhResource;
use App\Imports\ImportBantuanPkh;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Alignment;
use Maatwebsite\Excel\Facades\Excel;

class ManageBantuanPkh extends ManageRecords
{
    protected static string $resource = BantuanPkhResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Unggah Data')
                ->modalHeading('Unggah Data Bantuan PKH')
                ->createAnother(false)
                ->modalDescription('Unggah data PKH ke database dari file excel')
                ->modalSubmitActionLabel('Unggah')
                ->modalIcon('heroicon-o-arrow-down-tray')
                ->mutateFormDataUsing(function ($data) {
                    $import = Excel::import(new ImportBantuanPkh, $data['attachment'], 'public');
                    if ($import) {
                        Notification::make()
                            ->title('Data PKH Berhasil di impor')
                            ->success()
                            ->sendToDatabase(auth()->user());
                    }
                })
                ->icon('heroicon-o-arrow-down-tray')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->successRedirectUrl(route('filament.admin.resources.bantuan-pkh.index'))
                ->modalWidth('lg'),
        ];
    }
}
