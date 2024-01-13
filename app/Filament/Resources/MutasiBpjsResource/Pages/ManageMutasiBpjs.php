<?php

namespace App\Filament\Resources\MutasiBpjsResource\Pages;

use App\Filament\Resources\MutasiBpjsResource;
use App\Imports\ImportMutasiBpjs;
use App\Models\UsulanPengaktifanTmt;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Alignment;
use Maatwebsite\Excel\Facades\Excel;

class ManageMutasiBpjs extends ManageRecords
{
    protected static string $resource = MutasiBpjsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('unggahData')
                ->model(UsulanPengaktifanTmt::class)
                ->label('Unggah Data')
                ->modalHeading('Unggah Mutasi BPJS')
                ->modalDescription('Unggah Mutasi BPJS ke database')
                ->modalSubmitActionLabel('Unggah')
                ->color('success')
                ->modalIcon('heroicon-o-arrow-down-tray')
                ->form([
                    FileUpload::make('attachment')
                        ->label('Impor')
                        ->hiddenLabel()
                        ->columnSpanFull()
                        ->preserveFilenames()
                        ->previewable(false)
                        ->directory('upload')
                        ->maxSize(5120)
                        ->reorderable()
                        ->appendFiles()
                        ->storeFiles(false)
                        ->acceptedFileTypes([
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'text/csv'
                        ])
//                        ->hiddenOn(['edit', 'view']),
                ])
                ->action(function (array $data): void {
                    $import = Excel::import(new ImportMutasiBpjs, $data['attachment'], 'public');
                    if ($import) {
                        Notification::make()
                            ->title('Mutasi BPJS Berhasil di impor')
                            ->success()
                            ->sendToDatabase(auth()->user());
                    }
                })
//                ->icon('heroicon-o-arrow-down-tray')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->successRedirectUrl(route('filament.admin.resources.mutasi-bpjs.index'))
                ->modalWidth('lg'),

            Actions\CreateAction::make()
        ];
    }
}
