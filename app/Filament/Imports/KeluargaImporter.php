<?php

namespace App\Filament\Imports;

use App\Models\Kecamatan;
use App\Models\Keluarga;
use App\Models\Kelurahan;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Carbon;

class KeluargaImporter extends Importer
{
    protected static ?string $model = Keluarga::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('dtks_id')
                ->label('DTKS ID')
                ->example(\Str::uuid()->toString())
                ->rules(['max:36']),
            ImportColumn::make('nokk')
                ->label('NO. KARTU KELUARGA (KK)')
                ->example('73122308190001')
                ->requiredMapping()
                ->rules(['required', 'max:20']),
            ImportColumn::make('nik')
                ->label('N I K')
                ->example('73122308190001')
                ->requiredMapping()
                ->rules(['required', 'max:20']),
            ImportColumn::make('nama_lengkap')
                ->label('NAMA LENGKAP')
                ->example('Andini Sukarnain')
                ->requiredMapping()
                ->fillRecordUsing(function (Keluarga $keluarga, string $state): void {
                    $keluarga->nama_lengkap = strtoupper($state);
                })
                ->rules(['required', 'max:255']),
            ImportColumn::make('tempat_lahir')
                ->label('TEMPAT LAHIR')
                ->requiredMapping()
                ->example('Watansoppeng')
                ->rules(['required', 'max:50']),
            ImportColumn::make('tgl_lahir')
                ->label('TGL LAHIR')
                ->requiredMapping()
                ->castStateUsing(function ($state) {
                    if (blank($state)) {
                        return null;
                    }

                    return Carbon::createFromFormat('Y-m-d', $state);
                })
                ->example('19/09/1987')
                ->fillRecordUsing(function (Keluarga $keluarga, string $state): void {
                    $keluarga->tgl_lahir = Carbon::createFromFormat('Y-m-d H:i:s', $state);
                })
                ->rules(['required', 'datetime']),
            ImportColumn::make('notelp')
                ->label('NO. TELP/WA')
                ->requiredMapping()
                ->example('081235473373')
                ->rules(['required', 'max:12']),

            ImportColumn::make('alamat_penerima')
                ->label('ALAMAT LENGKAP')
                ->requiredMapping()
                ->example('Jln. Salotungo')
                ->rules(['required', 'max:255']),
            ImportColumn::make('no_rt')
                ->label('NO. RT')
                ->example('001')
                ->rules(['max:255']),
            ImportColumn::make('no_rw')
                ->label('NO. RW')
                ->example('002')
                ->rules(['max:255']),
            ImportColumn::make('kecamatan')
                ->label('KECAMATAN')
                ->requiredMapping()
                ->relationship(resolveUsing: ['name', 'code'])
                ->example('Lalabata')
                ->fillRecordUsing(function (Keluarga $keluarga, string $state): void {
                    $keluarga->kecamatan = Kecamatan::where(
                        'name',
                        '=', \Str::ucfirst(trim($state))
                    )->first()->code;
                })
                ->rules(['required', 'max:255']),
            ImportColumn::make('kelurahan')
                ->label('KELURAHAN')
                ->requiredMapping()
                ->relationship(resolveUsing: ['name', 'code'])
                ->example('Lalabata')
                ->fillRecordUsing(function (Keluarga $keluarga, string $state): void {
                    $keluarga->kelurahan = Kelurahan::where(
                        'name',
                        '=', \Str::ucfirst(trim($state))
                    )->first()->code;
                })
                ->rules(['required', 'max:255']),
            ImportColumn::make('dusun')
                ->label('DUSUN')
                ->rules(['max:255']),
            ImportColumn::make('kodepos')
                ->label('KODE POS')
                ->example('90861')
                ->rules(['max:255']),
//            ImportColumn::make('latitude')
//                ->label('LATITUDE')
//                ->rules(['max:255']),
//            ImportColumn::make('longitude')
//                ->label('LONGITUDE')
//                ->rules(['max:255']),

            ImportColumn::make('jenis_bantuan')
                ->label('BANTUAN')
                ->requiredMapping()
                ->relationship(resolveUsing: ['alias', 'nama_bantuan'])
                ->rules(['required']),
            ImportColumn::make('pendidikan_terakhir')
                ->label('PENDIDIKAN TERAKHIR')
                ->requiredMapping()
                ->relationship(resolveUsing: ['alias', 'nama_pendidikan'])
                ->rules(['required']),
            ImportColumn::make('hubungan_keluarga')
                ->label('HUBUNGAN KELUARGA')
                ->requiredMapping()
                ->relationship(resolveUsing: ['nama_hubungan'])
                ->rules(['required']),
            ImportColumn::make('jenis_pekerjaan')
                ->label('PEKERJAAN')
                ->requiredMapping()
                ->relationship(resolveUsing: ['nama_pekerjaan'])
                ->rules(['required']),
            ImportColumn::make('nama_ibu_kandung')
                ->label('NAMA IBU KANDUNG')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('status_kawin')
                ->label('STATUS KAWIN')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('jenis_kelamin')
                ->label('JENIS KELAMIN')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('status_keluarga')
                ->label('STATUS AKTIF')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('status_verifikasi')
                ->label('STATUS VERIFIKASI')
                ->rules(['max:255']),
            ImportColumn::make('unggah_foto')
                ->label('FOTO RUMAH'),
        ];
    }

    public static function getOptionsFormComponents(): array
    {
        return [
            Checkbox::make('update_existing')
                ->label('Update Data Yang Sudah Ada'),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Data penerima manfaat berhasil di impor dan ' . number_format
            ($import->successful_rows) .
            ' ' .
            str
            ('row')->plural($import->successful_rows) . ' telah diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' gagal di impor.';
        }

        return $body;
    }

    public function resolveRecord(): ?Keluarga
    {
        if ($this->options['update_existing'] ?? false) {
            return Keluarga::firstOrNew([
                // Update existing records, matching them by `$this->data['column_name']`
                'dtks_id' => $this->data['dtks_id'],
                'nik' => $this->data['nik'],
                'nokk' => $this->data['nokk'],
                'nama_ibu_kandung' => $this->data['nama_ibu_kandung'],
            ]);
        }

        return new Keluarga();
    }
}
