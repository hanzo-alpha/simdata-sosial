<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Closure;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;
use Wallo\FilamentSelectify\Components\ToggleButton;

class Settings extends BaseSettings
{
    use HasPageShield;

    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Pengaturan';
    protected ?string $heading = 'Pengaturan Aplikasi';

    public function schema(): array|Closure
    {
        return [
            Tabs::make('Pengaturan')
                ->schema([
                    Tabs\Tab::make('Aplikasi')
                        ->icon('heroicon-o-computer-desktop')
                        ->schema([
                            Group::make([
                                Section::make('Sistem')
                                    ->icon('heroicon-o-computer-desktop')
                                    ->schema([
                                        TextInput::make('app.brand_name')
                                            ->label('Nama Aplikasi')
                                            ->default('RENO'),
                                        TextInput::make('app.brand_description')
                                            ->label('Deskripsi Aplikasi')
                                            ->default('RENO'),
                                        TextInput::make('app.version')
                                            ->label('Versi Aplikasi')
                                            ->default('v1.0.0'),
                                        ToggleButton::make('app.darkmode')
                                            ->onColor('primary')
                                            ->offColor('danger')
                                            ->onLabel('Aktif')
                                            ->offLabel('Non Aktif'),
                                    ])->columns(2),
                                Section::make('Default')
                                    ->icon('heroicon-o-bars-4')
                                    ->schema([
                                        TextInput::make('app.kodeprov')
                                            ->label('Kode Provinsi'),
                                        TextInput::make('app.kodekab')
                                            ->label('Kode Kabupaten'),
                                        TextInput::make('app.kodepos')
                                            ->label('Kode POS'),
                                        Select::make('app.format_tgl')
                                            ->label('Format Tanggal')
                                            ->options([
                                                'd-m-Y' => 'dd-mm-yyyy',
                                                'Y-m-d' => 'yyyy-mm-dd',
                                                'd/m/Y' => 'dd/mm/yyyy',
                                                'Y/m/d' => 'yyyy/mm/dd',
                                                'd.m.Y' => 'dd.mm.yyyy',
                                                'Y.m.d' => 'yyyy.mm.dd',
                                                'd F Y' => 'dd mm yyyy',
                                            ]),

                                    ])->columns(2),
                            ]),

                            Group::make([
                                Section::make('Pengkodean Otomatis')
                                    ->icon('heroicon-o-code-bracket')
                                    ->schema([
                                        TextInput::make('app.judul_no')
                                            ->label('Judul No. Berita Acara'),
                                        TextInput::make('app.separator')
                                            ->label('Pemisah Nomor Surat'),
                                        TextInput::make('app.pad')
                                            ->label('Simbol Nomor Surat'),
                                        TextInput::make('app.no_ppks')
                                            ->label('Nomor Dinas'),
                                        TextInput::make('app.no_ba_ppks')
                                            ->label('Nomor Berita Acara PPKS'),
                                        TextInput::make('app.alias_dinas')
                                            ->label('Singkatan Dinas'),
                                    ])->columns(3),

                                Section::make('Pendukung Aplikasi')
                                    ->icon('heroicon-o-lifebuoy')
                                    ->schema([
                                        TextInput::make('app.angka_kemiskinan')
                                            ->label('Angka Kemiskinan'),
                                        TextInput::make('app.angka_kemiskinan_persen')
                                            ->mask('9.99')
                                            ->label('Angka Kemiskinan (%)'),
                                        ColorPicker::make('app.warna_kemiskinan')
                                            ->label('Warna Angka Kemiskinan'),
                                        DatePicker::make('app.batas_tgl_input')
                                            ->label('Batas Tanggal Penginputan Data')
                                            ->date()
                                            ->displayFormat(setting('app.format_tgl')),
                                        Grid::make()->schema([
                                            DatePicker::make('app.batas_tgl_input_bpjs')
                                                ->label('Batas Tanggal Input Data BPJS')
                                                ->date()
                                                ->displayFormat(setting('app.format_tgl')),
                                            DatePicker::make('app.batas_tgl_input_rastra')
                                                ->label('Batas Tanggal Input Data RASTRA')
                                                ->date()
                                                ->displayFormat(setting('app.format_tgl')),
                                            DatePicker::make('app.batas_tgl_input_ppks')
                                                ->label('Batas Tanggal Input Data PPKS')
                                                ->date()
                                                ->displayFormat(setting('app.format_tgl')),
                                        ])->columns(3),

                                    ])->columns(2),
                            ]),
                        ])->columns(2),
                    Tabs\Tab::make('Persuratan & Laporan')
                        ->icon('heroicon-o-envelope')
                        ->schema([
                            Group::make([
                                Section::make('Berita Acara & Lampiran BAST')
                                    ->icon('heroicon-o-envelope')
                                    ->schema([
                                        TextInput::make('ba.kop_title')
                                            ->label('Kop Judul')
                                            ->default('PEMERINTAH KABUPATEN SOPPENG'),
                                        TextInput::make('ba.kop_instansi')
                                            ->label('Kop Instansi')
                                            ->default('DINAS SOSIAL'),
                                        TextInput::make('ba.kop_website')
                                            ->label('Kop Website'),
                                        TextInput::make('ba.kop_jalan')
                                            ->label('Kop Jalan')
                                            ->default('Jalan Salotungo Kel. Lalabata Rilau Kec. Lalabata Watansoppeng'),
                                        TextInput::make('ba.kop_ba')
                                            ->label('Kop Judul Berita Acara')
                                            ->default('BERITA ACARA SERAH TERIMA BARANG'),
                                        ToggleButton::make('ba.kop_layout')
                                            ->label('Layout Kop/Judul Berita Acara')
                                            ->onLabel('Vertikal')
                                            ->offLabel('Horisontal'),
                                    ])->columns(2),
                                Section::make('Kepala Dinas')
                                    ->icon('heroicon-o-user')
                                    ->schema([
                                        TextInput::make('persuratan.nama_kepala_dinas')
                                            ->label('Nama Kepala Dinas'),
                                        TextInput::make('persuratan.nip_kepala_dinas')
                                            ->label('NIP Kepala Dinas'),
                                        TextInput::make('persuratan.jabatan')
                                            ->label('Jabatan Kepala Dinas'),
                                        TextInput::make('persuratan.pangkat')
                                            ->label('Pangkat Kepala Dinas'),
                                    ])->columns(2),
                            ]),
                            Group::make([
                                Section::make('Pejabat Pelaksana Teknis Kegiatan (RASTRA)')
                                    ->icon('heroicon-o-user')
                                    ->schema([
                                        TextInput::make('persuratan.nama_pps')
                                            ->label('Nama Pejabat'),
                                        TextInput::make('persuratan.nip_pps')
                                            ->label('Nip Pejabat'),
                                        TextInput::make('persuratan.jabatan_pps')
                                            ->label('Jabatan Pejabat'),
                                        TextInput::make('persuratan.pangkat_pps')
                                            ->label('Pangkat Pejabat'),
                                        TextInput::make('persuratan.instansi_pps')
                                            ->label('Instansi Pejabat')
                                            ->default('DINAS SOSIAL KAB. SOPPENG'),
                                    ])->columns(2),
                                Section::make('Pejabat Pelaksana Teknis Kegiatan (PPKS)')
                                    ->icon('heroicon-o-user')
                                    ->schema([
                                        TextInput::make('persuratan.nama_ppk')
                                            ->label('Nama Pejabat'),
                                        TextInput::make('persuratan.nip_ppk')
                                            ->label('Nip Pejabat'),
                                        TextInput::make('persuratan.jabatan_ppk')
                                            ->label('Jabatan Pejabat'),
                                        TextInput::make('persuratan.pangkat_ppk')
                                            ->label('Pangkat Pejabat'),
                                        TextInput::make('persuratan.instansi_ppk')
                                            ->label('Instansi Pejabat')
                                            ->default('DINAS SOSIAL KAB. SOPPENG'),
                                    ])->columns(2),
                            ]),
                        ])->columns(2),
                ]),
        ];
    }
}
