<?php

namespace App\Filament\Resources\PesertaBpjsResource\Pages;

use App\Filament\Resources\PesertaBpjsResource;
use App\Filament\Widgets\PesertaBpjsOverview;
use App\Imports\ImportPesertaBpjs;
use App\Models\PesertaBpjs;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Alignment;
use Maatwebsite\Excel\Facades\Excel;

class ManagePesertaBpjs extends ManageRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = PesertaBpjsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Unggah Data')
                ->createAnother(false)
                ->modalHeading('Unggah Data Peserta BPJS')
                ->modalDescription('Unggah Peserta BPJS ke database')
                ->modalSubmitActionLabel('Unggah')
                ->modalIcon('heroicon-o-arrow-down-tray')
                ->action(function (array $data): void {
                    $deleteAll = PesertaBpjs::query()->delete();
                    if ($deleteAll) {
                        Excel::import(new ImportPesertaBpjs(), $data['attachment'], 'public');
                        Notification::make()
                            ->title('Usulan Peserta BPJS Berhasil di impor')
                            ->success()
                            ->sendToDatabase(auth()->user());
                    }
                })
                ->icon('heroicon-o-arrow-down-tray')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->successRedirectUrl(route('filament.admin.resources.peserta-bpjs.index'))
                ->modalWidth('lg'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PesertaBpjsOverview::class
        ];
    }

}
