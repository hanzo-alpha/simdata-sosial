<?php

namespace App\Filament\Resources\UsulanPengaktifanTmtResource\Pages;

use App\Exports\ExportBantuanRastra;
use App\Exports\ExportUsulanPengaktifanTmt;
use App\Filament\Resources\UsulanPengaktifanTmtResource;
use App\Imports\ImportUsulanPengaktifanTmt;
use App\Models\UsulanPengaktifanTmt;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListUsulanPengaktifanTmt extends ListRecords
{
    protected static string $resource = UsulanPengaktifanTmtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()->label('Ekspor Data')
                ->color('info')
                ->exports([
                    ExportUsulanPengaktifanTmt::make()
                        ->except(['created_at', 'updated_at', 'deleted_at']),
//                    ExportUsulanPengaktifanTmt::make('form')
//                        ->fromForm()
//                        ->except(['created_at', 'updated_at', 'deleted_at'])
                ]),
            Actions\Action::make('import')
                ->model(UsulanPengaktifanTmt::class)
                ->label('Impor Data')
                ->modalHeading('Unggah Usulan Pengaktifan TMT')
                ->modalDescription('Unggah Usulan Pengaktifan TMT ke database')
                ->modalSubmitActionLabel('Unggah')
                ->color('success')
                ->modalIcon('heroicon-o-arrow-up-tray')
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
                    $import = Excel::import(new ImportUsulanPengaktifanTmt, $data['attachment'], 'public');
                    if ($import) {
                        Notification::make()
                            ->title('Usulan Pengaktifan TMT Berhasil di impor')
                            ->success()
                            ->sendToDatabase(auth()->user());
                    } else {
                        Notification::make()
                            ->title('Usulan Pengaktifan TMT Gagal di impor')
                            ->danger()
                            ->sendToDatabase(auth()->user());
                    }
                })
                ->icon('heroicon-o-arrow-up-tray')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->successRedirectUrl(route('filament.admin.resources.usulan-pengaktifan-tmt.index'))
                ->modalWidth('md'),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
