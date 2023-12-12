<?php

declare(strict_types=1);

namespace App\Exports;

use App\Enums\JenisKelaminEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ExportUsulanPengaktifanTmt extends ExcelExport implements ShouldQueue
{
    public function setUp(): void
    {
        $this->askForFilename();
        $this->withFilename(fn($filename) => date('Ymdhis') . '-' . $filename . '-ekspor');
        $this->askForWriterType();
        $this->withColumns([
            Column::make('nokk_tmt')->heading('No. KK'),
            Column::make('nik_tmt')->heading('N I K'),
            Column::make('nama_lengkap')->heading('Nama Lengkap'),
            Column::make('tempat_lahir')->heading('Tempat Lahir'),
            Column::make('tgl_lahir')->heading('Tgl. Lahir'),
            Column::make('jenis_kelamin')->heading('Jenis Kelamin'),
            Column::make('status_nikah')->heading('Status Kawin'),
            Column::make('alamat')->heading('Alamat Tempat Tinggal'),
            Column::make('nort')->heading('RT'),
            Column::make('norw')->heading('RW'),
            Column::make('kodepos')->heading('Kode Pos'),
            Column::make('kecamatan')->heading('Kecamatan'),
            Column::make('kelurahan')->heading('Kelurahan'),
            Column::make('dusun')->heading('Dusun'),
            Column::make('status_aktif')->heading('Status Aktif'),
        ]);
        $this->queue()->withChunkSize(500);
    }
}
