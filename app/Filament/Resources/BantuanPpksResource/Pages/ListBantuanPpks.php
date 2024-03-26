<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPpksResource\Pages;

use App\Filament\Exports\BantuanPpksExporter;
use App\Filament\Imports\BantuanPpksImporter;
use App\Filament\Resources\BantuanPpksResource;
use App\Models\TipePpks;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

final class ListBantuanPpks extends ListRecords
{
    protected static string $resource = BantuanPpksResource::class;

    public function getTabs(): array
    {
        $bantuan = TipePpks::pluck('nama_tipe', 'id');
        return [
            'all' => Tab::make(),
            $bantuan[1] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 1)
                )),
            $bantuan[2] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 2)
                )),
            $bantuan[3] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 3)
                )),
            $bantuan[4] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 4)
                )),
            $bantuan[5] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 5)
                )),
            $bantuan[6] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 6)
                )),
            $bantuan[7] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 7)
                )),
            $bantuan[8] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 8)
                )),
            $bantuan[9] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 9)
                )),
            $bantuan[10] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 10)
                )),
            $bantuan[11] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 11)
                )),
            $bantuan[12] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 12)
                )),
            $bantuan[13] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 13)
                )),
            $bantuan[14] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 14)
                )),
            $bantuan[15] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 15)
                )),
            $bantuan[16] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 16)
                )),
            $bantuan[17] => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas(
                    'tipe_ppks',
                    fn(Builder $query) => $query->where('id', 17)
                )),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            //            ExportAction::make()->label('Ekspor XLS')
            //                ->color('success')
            //                ->exports([
            //                    ExportBantuanPpks::make(),
            //                ]),

            Actions\ExportAction::make()
                ->label('Download CSV')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray')
                ->exporter(BantuanPpksExporter::class),

            Actions\ImportAction::make()
                ->label('Upload CSV')
                ->color('warning')
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(BantuanPpksImporter::class)
                ->options([
                    'updateExisting' => true,
                ]),
            //            Actions\Action::make('import')
            //                ->model(BantuanPpks::class)
            //                ->label('Impor Data')
            //                ->modalHeading('Unggah Data Bantuan PPKS')
            //                ->modalDescription('Unggah data PPKS ke database dari file excel')
            //                ->modalSubmitActionLabel('Unggah')
            //                ->modalIcon('heroicon-o-arrow-up-tray')
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
            //                            'text/csv',
            //                        ])
            //                        ->hiddenOn(['edit', 'view']),
            //                ])
            //                ->action(function (array $data): void {
            //                    $import = Excel::import(new ImportBantuanPpks(), $data['attachment'], 'public');
            //                    if ($import) {
            //                        Notification::make()
            //                            ->title('Data PPKS Berhasil di impor')
            //                            ->success()
            //                            ->sendToDatabase(auth()->user());
            //                    }
            //                })
            //                ->icon('heroicon-o-arrow-up-tray')
            //                ->color('info')
            //                ->modalAlignment(Alignment::Center)
            //                ->closeModalByClickingAway(false)
            //                ->successRedirectUrl(route('filament.admin.resources.program-ppks.index'))
            //                ->modalWidth('lg'),

            Actions\CreateAction::make()
                ->icon('heroicon-o-plus'),

        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }

    //    protected function getHeaderWidgets(): array
    //    {
    //        return [
    //            BantuanPpksOverview::class,
    //        ];
    //    }
}
