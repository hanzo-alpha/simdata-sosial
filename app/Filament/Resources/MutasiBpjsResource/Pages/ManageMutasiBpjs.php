<?php

namespace App\Filament\Resources\MutasiBpjsResource\Pages;

use App\Filament\Resources\MutasiBpjsResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMutasiBpjs extends ManageRecords
{
    protected static string $resource = MutasiBpjsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->closeModalByClickingAway(false),

            //            Actions\Action::make('unggahData')
            //                ->model(PesertaBpjs::class)
            //                ->label('Unggah Data')
            //                ->modalHeading('Unggah Mutasi BPJS')
            //                ->modalDescription('Unggah Mutasi BPJS ke database')
            //                ->modalSubmitActionLabel('Unggah')
            //                ->color('success')
            //                ->modalIcon('heroicon-o-arrow-down-tray')
            //                ->form([
            //                    FileUpload::make('attachment')
            //                        ->label('Impor')
            //                        ->hiddenLabel()
            //                        ->columnSpanFull()
            //                        ->preserveFilenames()
            //                        ->previewable(false)
            //                        ->directory('upload')
            //                        ->maxSize(5120)
            //                        ->reorderable()
            //                        ->appendFiles()
            //                        ->storeFiles(false)
            //                        ->acceptedFileTypes([
            //                            'application/vnd.ms-excel',
            //                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            //                            'text/csv'
            //                        ])
            ////                        ->hiddenOn(['edit', 'view']),
            //                ])
            //                ->action(function (array $data): void {
            //                    $import = Excel::import(new ImportMutasiBpjs, $data['attachment'], 'public');
            //                    if ($import) {
            //                        Notification::make()
            //                            ->title('Mutasi BPJS Berhasil di impor')
            //                            ->success()
            //                            ->sendToDatabase(auth()->user());
            //                    }
            //                })
            //                ->icon('heroicon-o-arrow-down-tray')
            //                ->modalAlignment(Alignment::Center)
            //                ->closeModalByClickingAway(false)
            //                ->successRedirectUrl(route('filament.admin.resources.mutasi-bpjs.index'))
            //                ->modalWidth('lg'),

        ];
    }
}
