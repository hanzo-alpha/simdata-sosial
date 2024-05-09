<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPkhResource\Pages;

use App\Exports\ExportBantuanPkh;
use App\Filament\Resources\BantuanBpjsResource\Widgets\BantuanBpjsOverview;
use App\Filament\Resources\BantuanPkhResource;
use App\Imports\ImportBantuanPkh;
use App\Models\BantuanPkh;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

final class ListBantuanPkh extends ListRecords
{
    use HasInputDateLimit;

    protected static string $resource = BantuanPkhResource::class;

    public function getTabs(): array
    {
        $results = collect();
        $bantuan = Kelurahan::query()->whereIn('kecamatan_code', config('custom.kode_kecamatan'))->get();
        $bantuan->each(function ($item, $key) use (&$results): void {
            $results->put('semua', Tab::make()->badge(BantuanPkh::query()->count()));
            $results->put(Str::lower($item->name), Tab::make()
                ->badge(BantuanPkh::query()->whereHas(
                    'kel',
                    fn(Builder $query) => $query->where('bantuan_pkh.kelurahan', $item->code),
                )->count())
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereHas(
                        'kel',
                        fn(Builder $query) => $query->where('bantuan_pkh.kelurahan', $item->code),
                    ),
                ));
        });

        return $results->toArray();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BantuanPkhResource\Widgets\BantuanPkhOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            //            Actions\CreateAction::make()
            //                ->label('Buat Baru')
            //                ->icon('heroicon-o-plus'),
            ExportAction::make()
                ->label('Download XLS')
                ->color('info')
                ->exports([
                    ExportBantuanPkh::make()
                        ->except(['created_at', 'updated_at', 'deleted_at']),
                ])
                ->disabled($this->enableInputLimitDate()),
            Actions\Action::make('unggahData')
//                ->model(BantuanPkh::class)
                ->label('Upload XLS')
                ->modalHeading('Unggah Data Bantuan PKH')
                ->modalDescription('Unggah data PKH ke database dari file excel')
                ->modalSubmitActionLabel('Unggah')
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
                            'text/csv',
                        ])
                        ->hiddenOn(['edit', 'view']),
                ])
                ->action(function (array $data): void {
                    $import = new ImportBantuanPkh();
                    $import->import($data['attachment'], 'public');

                    if ($import) {
                        Notification::make()
                            ->title('Data PKH Berhasil di impor')
                            ->success()
                            ->sendToDatabase(auth()->user());
                    } else {
                        Notification::make()
                            ->title('Data PKH Gagal di impor')
                            ->danger()
                            ->sendToDatabase(auth()->user());
                    }

                    //                   Log::error($import->errors());

                })
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->disabled($this->enableInputLimitDate())
                ->successRedirectUrl(route('filament.admin.resources.program-pkh.index'))
                ->modalWidth('lg'),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
