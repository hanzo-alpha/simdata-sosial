<?php

namespace App\Filament\Resources\DataPesertaJamkesdaResource\Pages;

use App\Filament\Resources\DataPesertaJamkesdaResource;
use App\Imports\ImportPesertaJamkesda;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Alignment;
use Maatwebsite\Excel\Facades\Excel;

class ManageDataPesertaJamkesda extends ManageRecords
{
    protected static string $resource = DataPesertaJamkesdaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Unggah Data')
                ->createAnother(false)
                ->modalHeading('Unggah Data Peserta JAMKESDA')
                ->modalDescription('Unggah Peserta JAMKESDA ke database')
                ->modalSubmitActionLabel('Unggah')
                ->modalIcon('heroicon-o-arrow-down-tray')
                ->action(function (array $data): void {
                    $import = Excel::import(new ImportPesertaJamkesda, $data['attachment'], 'public');
                    if ($import) {
                        Notification::make()
                            ->title('Usulan Peserta JAMKESDA Berhasil di impor')
                            ->success()
                            ->sendToDatabase(auth()->user());
                    }
                })
                ->icon('heroicon-o-arrow-down-tray')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->successRedirectUrl(route('filament.admin.resources.peserta-jamkesda.index'))
                ->modalWidth('lg'),
        ];
    }
}
