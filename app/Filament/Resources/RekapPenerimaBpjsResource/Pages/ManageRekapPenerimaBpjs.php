<?php

declare(strict_types=1);

namespace App\Filament\Resources\RekapPenerimaBpjsResource\Pages;

use App\Filament\Imports\RekapPenerimaBpjsImporter;
use App\Filament\Resources\RekapPenerimaBpjsResource;
use App\Models\Kelurahan;
use App\Models\RekapPenerimaBpjs;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ManageRekapPenerimaBpjs extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = RekapPenerimaBpjsResource::class;

    public function getTabs(): array
    {
        $results = collect();

        $bantuan = Kelurahan::query()->whereIn('kecamatan_code', config('custom.kode_kecamatan'))->get();
        $bantuan->each(function ($item, $key) use (&$results): void {
            $results->put('semua', Tab::make()
                ->badge(RekapPenerimaBpjs::query()->sum('jumlah')));
            $results->put(Str::lower($item->name), Tab::make()
                ->badge(RekapPenerimaBpjs::query()->whereHas(
                    'kel',
                    function (Builder $query) use ($item): void {
                        $query->where('rekap_penerima_bpjs.kelurahan', $item->code);

                    },
                )->sum('jumlah'))
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereHas(
                        'kel',
                        function (Builder $query) use ($item): void {
                            $query->where('rekap_penerima_bpjs.kelurahan', $item->code);

                        },
                    ),
                ));
        });

        return $results->toArray();

    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->label('Upload CSV')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('warning')
                ->importer(RekapPenerimaBpjsImporter::class)
                ->options([
                    'updateExisting' => true,
                ])
                ->maxRows(5000)
                ->chunkSize(100)
                ->disabled($this->enableInputLimitDate('bpjs'))
                ->closeModalByClickingAway(false),

            Actions\CreateAction::make()
                ->disabled($this->enableInputLimitDate('bpjs'))
                ->mutateFormDataUsing(function (array $data) {
                    $data['provinsi'] = setting('app.kodeprov', '73');
                    $data['kabupaten'] = setting('app.kodekab', '7312');
                    return $data;
                })
                ->icon('heroicon-o-plus'),
        ];
    }
}
