<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanBpntResource\Pages;

use App\Filament\Resources\BantuanBpntResource;
use App\Imports\ImportBantuanBpnt;
use App\Models\BantuanPkh;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class ListBantuanBpnt extends ListRecords
{
    protected static string $resource = BantuanBpntResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('unggahData')
                ->model(BantuanPkh::class)
                ->label('Unggah Data')
                ->modalHeading('Unggah Data Bantuan BPNT')
                ->modalDescription('Unggah data BPNT ke database dari file excel')
                ->modalSubmitActionLabel('Unggah')
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
                            'text/csv',
                        ])
                        ->hiddenOn(['edit', 'view']),
                ])
                ->action(function (array $data): void {
                    $import = new ImportBantuanBpnt();
                    $import->import($data['attachment'], 'public');

                    if ($import) {
                        Notification::make()
                            ->title('Data Bantuan BPNT Berhasil di impor')
                            ->success()
                            ->send()
                            ->sendToDatabase(auth()->user());
                    } else {
                        Notification::make()
                            ->title('Data Bantuan BPNT Gagal di impor')
                            ->danger()
                            ->send()
                            ->sendToDatabase(auth()->user());
                    }
                })
                ->icon('heroicon-o-arrow-down-tray')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->successRedirectUrl(route('filament.admin.resources.program-bpnt.index'))
                ->modalWidth('lg'),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
