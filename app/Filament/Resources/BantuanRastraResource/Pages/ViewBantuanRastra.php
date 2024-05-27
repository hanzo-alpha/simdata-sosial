<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanRastraResource\Pages;

use App\Enums\AlasanEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusDtksEnum;
use App\Enums\StatusRastra;
use App\Enums\StatusVerifikasiEnum;
use App\Filament\Resources\BantuanRastraResource;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Actions;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\MaxWidth;

final class ViewBantuanRastra extends ViewRecord
{
    protected static string $resource = BantuanRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->icon('heroicon-o-pencil-square'),
            Actions\Action::make('pengganti_rastra')
                ->label('Ganti KPM Baru')
                ->icon('heroicon-s-arrow-path-rounded-square')
                ->color('success')
                ->form([
                    Grid::make()->schema([
                        TextInput::make('nokk')
                            ->label('No. KK Pengganti')
                            ->maxValue(16)
                            ->required(),
                        TextInput::make('nik')
                            ->label('NIK Pengganti')
                            ->required()
                            ->maxValue(16)
                            ->unique(ignoreRecord: true),
                        TextInput::make('nama_lengkap')
                            ->label('Nama Pengganti')
                            ->required(),
                        TextInput::make('alamat')
                            ->label('Alamat Pengganti')
                            ->nullable(),
                        Select::make('kecamatan')
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->options(function () {
                                $kab = Kecamatan::query()
                                    ->where('kabupaten_code', setting(
                                        'app.kodekab',
                                        config('custom.default.kodekab'),
                                    ));
                                if (!$kab) {
                                    return Kecamatan::where('kabupaten_code', setting(
                                        'app.kodekab',
                                        config('custom.default.kodekab'),
                                    ))
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                        Select::make('kelurahan')
                            ->required()
                            ->options(function (callable $get) {
                                return Kelurahan::query()->where('kecamatan_code', $get('kecamatan'))?->pluck(
                                    'name',
                                    'code',
                                );
                            })
                            ->reactive()
                            ->searchable(),
                        Select::make('pengganti_rastra.alasan_dikeluarkan')
                            ->searchable()
                            ->options(AlasanEnum::class)
                            ->enum(AlasanEnum::class)
                            ->native(false)
                            ->preload()
                            ->lazy()
                            ->required()
                            ->default(AlasanEnum::PINDAH),
                        CuratorPicker::make('pengganti_rastra.media_id')
                            ->label('Upload Berita Acara Pengganti')
                            ->relationship('beritaAcara', 'id')
                            ->buttonLabel('Tambah File')
                            ->required()
                            ->rules(['required'])
                            ->maxSize(2048),
                    ])->columns(2),
                ])
                ->modalWidth(MaxWidth::FourExtraLarge)
                ->action(function ($record, array $data): void {
                    $keluargaDigantiId = $record->id;

                    $record->pengganti_rastra()->updateOrCreate([
                        'bantuan_rastra_id' => $keluargaDigantiId,
                        'nik_pengganti' => $data['nik'],
                        'nokk_pengganti' => $data['nokk'],
                        'nama_pengganti' => $data['nama_lengkap'],
                        'alamat_pengganti' => $data['alamat'],
                        'alasan_dikeluarkan' => $data['pengganti_rastra']['alasan_dikeluarkan'],
                        'media_id' => $data['pengganti_rastra']['media_id'],
                    ], [
                        'bantuan_rastra_id' => $record->id,
                        'nik_pengganti' => $data['nik'],
                        'nama_pengganti' => $data['nama_lengkap'],
                    ]);

                    $record->create([
                        'nama_lengkap' => $data['nama_lengkap'],
                        'nik' => $data['nik'],
                        'nokk' => $data['nokk'],
                        'alamat' => $data['alamat'],
                        'kecamatan' => $data['kecamatan'],
                        'kelurahan' => $data['kelurahan'],
                        'status_rastra' => StatusRastra::BARU,
                        'status_dtks' => StatusDtksEnum::DTKS,
                        'status_verifikasi' => StatusVerifikasiEnum::VERIFIED,
                        'status_aktif' => StatusAktif::AKTIF,
                    ]);

                    $record->status_rastra = StatusRastra::PENGGANTI;
                    $record->status_aktif = StatusAktif::NONAKTIF;
                    $record->save();

                })
                ->after(function (): void {
                    Notification::make()
                        ->success()
                        ->title('Perubahan Berhasil Disimpan')
                        ->send();
                })
                ->close(),
        ];
    }
}
