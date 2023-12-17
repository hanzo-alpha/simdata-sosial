<?php

declare(strict_types=1);

namespace App\Exports;

use App\Enums\StatusVerifikasiEnum;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ExportBantuanRastra extends ExcelExport
{
    public function setUp()
    {
        $this->askForFilename();
        $this->withFilename(fn($filename) => date('Ymdhis') . '-' . $filename . '-ekspor');
        $this->askForWriterType();
        $this->modifyQueryUsing(fn($query) => $query->with([
            'alamat',
            'alamat.kec',
            'alamat.kel',
            'jenis_bantuan',
            'pendidikan_terakhir',
            'hubungan_keluarga',
            'jenis_pekerjaan'
        ]));
        $this->withColumns([
            Column::make('dtks_id')->heading('DTKS ID'),
            Column::make('nokk')->heading('No. KK'),
            Column::make('nik')->heading('N I K'),
            Column::make('nama_lengkap')->heading('Nama Lengkap'),
            Column::make('notelp')->heading('No. Telp/WA'),
            Column::make('tempat_lahir')->heading('Tempat Lahir'),
            Column::make('tgl_lahir')->heading('Tgl. Lahir')
                ->formatStateUsing(fn($record) => $record->tgl_lahir->format('d/M/Y')),
            Column::make('alamat.kec.name')->heading('Kecamatan'),
            Column::make('alamat.kel.name')->heading('Kelurahan'),
            Column::make('alamat.dusun')->heading('Dusun'),
            Column::make('alamat.no_rt')->heading('No.RT'),
            Column::make('alamat.no_rw')->heading('No.RW'),
            Column::make('jenis_bantuan.alias')->heading('Bantuan'),
            Column::make('jenis_pekerjaan.nama_pekerjaan')->heading('Pekerjaan'),
            Column::make('pendidikan_terakhir.nama_pendidikan')->heading('Pendidikan Terakhir'),
            Column::make('hubungan_keluarga.nama_hubungan')->heading('Hubungan Keluarga'),
            Column::make('status_kawin')->heading('Status Kawin'),
            Column::make('status_verifikasi')->heading('Status Verifikasi')
                ->formatStateUsing(fn($state) => match ($state) {
                    'UNVERIFIED' => StatusVerifikasiEnum::UNVERIFIED->getLabel(),
                    'VERIFIED' => StatusVerifikasiEnum::VERIFIED->getLabel(),
                    'REVIEW' => StatusVerifikasiEnum::REVIEW->getLabel(),
                }),
            Column::make('status_rastra')->heading('Status Rastra'),
            Column::make('bukti_foto')->heading('Foto Rumah'),
        ]);
        $this->queue()->withChunkSize(1000);
    }
}
