<?php
declare(strict_types=1);

namespace App\Exports;

use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ExportKeluarga extends ExcelExport
{
    public function setUp()
    {
        $this->askForFilename();
        $this->withFilename(fn($filename) => date('Ymdhis') . '-' . $filename . '-ekspor');
        $this->askForWriterType();
        $this->withColumns([
            Column::make('dtks_id')->heading('DTKS ID'),
            Column::make('nokk')->heading('No. KK'),
            Column::make('nik')->heading('N I K'),
            Column::make('nama_lengkap')->heading('Nama Lengkap'),
            Column::make('notelp')->heading('No. Telp/WA'),
            Column::make('tempat_lahir')->heading('Tempat Lahir'),
            Column::make('tgl_lahir')->heading('Tgl. Lahir'),
            Column::make('address.kec.name')->heading('Kecamatan'),
            Column::make('address.kel.name')->heading('Kelurahan'),
            Column::make('address.dusun')->heading('Dusun'),
            Column::make('address.no_rt')->heading('No.RT'),
            Column::make('address.no_rw')->heading('No.RW'),
        ]);
        $this->queue()->withChunkSize(500);
    }
}
