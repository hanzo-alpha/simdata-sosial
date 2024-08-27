<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeritaAcaraResource\Pages;

use App\Filament\Resources\BeritaAcaraResource;
use App\Models\BantuanRastra;
use App\Models\BeritaAcara;
use App\Models\Kecamatan;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ManageBeritaAcaras extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = BeritaAcaraResource::class;

    public function getTabs(): array
    {
        $results = collect();
        if (auth()->user()->hasRole(['super_admin', 'admin_rastra', 'admin'])) {
            $bantuan = Kecamatan::query()->where('kabupaten_code', setting('app.kodekab'))->get();
            $bantuan->each(function ($item, $key) use (&$results): void {
                $results->put('semua', Tab::make()->badge(BeritaAcara::query()->count()));
                $results->put(Str::lower($item->name), Tab::make()
                    ->badge(BeritaAcara::query()->whereHas(
                        'kec',
                        fn(Builder $query) => $query->where('berita_acara.kecamatan', $item->code),
                    )->count())
                    ->modifyQueryUsing(
                        fn(Builder $query) => $query->whereHas(
                            'kec',
                            fn(Builder $query) => $query->where('berita_acara.kecamatan', $item->code),
                        ),
                    ));
            });

            return $results->toArray();
        }

        return $results->toArray();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->using(function (array $data, string $model): Model {
                    $bantuan = BantuanRastra::query()
                        ->where('kecamatan', $data['kecamatan'])
                        ->where('kelurahan', $data['kelurahan'])
                        ->get();

                    $data['bantuan_rastra_ids'] = $bantuan->pluck('id');
                    return $model::create($data);
                })
                ->closeModalByClickingAway(false)
                ->disabled($this->enableInputLimitDate('rastra')),
        ];
    }
}
