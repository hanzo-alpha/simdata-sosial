<?php

namespace App\Filament\Pages\Settings;

use Closure;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;
use Wallo\FilamentSelectify\Components\ToggleButton;

class Settings extends BaseSettings
{
    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Sistem';

    protected ?string $heading = 'Pengaturan';

    public function schema(): array|Closure
    {
        return [
            Tabs::make('Pengaturan')
                ->schema([
                    Tabs\Tab::make('Aplikasi')
                        ->icon('heroicon-o-computer-desktop')
                        ->schema([
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
                            Section::make('Format')
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
                                        ]),
                                    DatePicker::make('app.batas_tgl_input')
                                        ->displayFormat(setting('app.format_tgl')),
                                ])->columns(2),
                            Section::make('Pengkodean Otomatis')
                                ->icon('heroicon-o-code-bracket')
                                ->schema([
                                    TextInput::make('app.nomor_surat_rastra')
                                        ->label('Nomor Surat RASTRA'),
                                    TextInput::make('app.separator')
                                        ->label('Pemisah Nomor Surat'),
                                    TextInput::make('app.pad')
                                        ->label('Simbol Nomor Surat'),
                                ])->columns(3),
                            Section::make('Pendukung')->schema([
                                TextInput::make('app.angka_kemiskinan')
                                    ->label('Angka Kemiskinan'),
                            ])->columns(2)
                        ])->columns(2),
                    Tabs\Tab::make('Persuratan')
                        ->icon('heroicon-o-envelope')
                        ->schema([
                            Section::make('Kepala Dinas')
                                ->icon('heroicon-o-envelope')
                                ->schema([
                                    TextInput::make('persuratan.nama_kepala_dinas')
                                        ->label('Nama Kepala Dinas')
                                        ->default('Hansen'),
                                    TextInput::make('persuratan.nip_kepala_dinas')
                                        ->label('NIP Kepala Dinas')
                                        ->default('Hansen'),
                                    TextInput::make('persuratan.jabatan')
                                        ->label('Jabatan Kepala Dinas')
                                        ->default('Hansen'),
                                    TextInput::make('persuratan.pangkat')
                                        ->label('Pangkat Kepala Dinas')
                                        ->default('Hansen'),
                                ])->columns(2),

                            Section::make('Pejabat Penanggungjawab')
                                ->icon('heroicon-o-user')
                                ->schema([
                                    TextInput::make('persuratan.nama_pps')
                                        ->label('Nama Pejabat')
                                        ->default('Hansen'),
                                    TextInput::make('persuratan.nip_pps')
                                        ->label('Nip Pejabat')
                                        ->default('Hansen'),
                                    TextInput::make('persuratan.jabatan_pps')
                                        ->label('Jabatan Pejabat')
                                        ->default('Hansen'),
                                    TextInput::make('persuratan.pangkat_pps')
                                        ->label('Pangkat Pejabat')
                                        ->default('Hansen'),
                                    TextInput::make('persuratan.instansi_pps')
                                        ->label('Instansi Pejabat')
                                        ->default('DINAS SOSIAL KAB. SOPPENG'),
                                ])->columns(2),
                        ])->columns(2),
                    Tabs\Tab::make('Laporan')
                        ->icon('heroicon-o-document-chart-bar')
                        ->schema([
                            Section::make('Berita Acara & Lampiran BAST')
                                ->icon('heroicon-o-document-chart-bar')
                                ->schema([
                                    TextInput::make('ba.kop_title')
                                        ->label('Kop Judul')
                                        ->default('PEMERINTAH KABUPATEN SOPPENG'),
                                    TextInput::make('ba.kop_instansi')
                                        ->label('Kop Judul')
                                        ->default('DINAS SOSIAL'),
                                    TextInput::make('ba.kop_website')
                                        ->label('Kop Website')
                                        ->default('Website : https://dinsos.@soppengkab.go.id/, Email : dinsos01.soppeng@gmail.com'),
                                    TextInput::make('ba.kop_jalan')
                                        ->label('Kop Jalan')
                                        ->default('Jalan Salotungo Kel. Lalabata Rilau Kec. Lalabata Watansoppeng'),
                                ])->columns(2),
                        ])
                ]),
        ];
    }
}
