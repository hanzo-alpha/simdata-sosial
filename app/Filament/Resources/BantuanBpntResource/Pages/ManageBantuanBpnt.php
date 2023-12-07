<?php

namespace App\Filament\Resources\BantuanBpntResource\Pages;

use App\Filament\Resources\BantuanBpntResource;
use App\Imports\ImportBantuanBpnt;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Alignment;
use Maatwebsite\Excel\Facades\Excel;

class ManageBantuanBpnt extends ManageRecords
{
    protected static string $resource = BantuanBpntResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Unggah Data')
                ->modalHeading('Unggah Data Bantuan BPNT')
                ->createAnother(false)
                ->modalDescription('Unggah data BPNT ke database dari file excel')
                ->modalSubmitActionLabel('Unggah')
                ->modalIcon('heroicon-o-arrow-down-tray')
                ->mutateFormDataUsing(function ($data) {
                    $import = Excel::import(new ImportBantuanBpnt, $data['attachment'], 'public');
                    if ($import) {
                        Notification::make()
                            ->title('Data Berhasil di Import')
                            ->success()
                            ->sendToDatabase(auth()->user());
                    }
                })
                ->icon('heroicon-o-arrow-down-tray')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->successRedirectUrl(route('filament.admin.resources.bantuan-bpnt.index'))
                ->modalWidth('lg'),
        ];
    }
}
