<?php

namespace App\Filament\Pages\Settings;

use Closure;
use Filament\Forms\Components\DatePicker;
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

                            ToggleButton::make('app.darkmode')
                                ->onColor('primary')
                                ->offColor('danger')
                                ->onLabel('Aktif')
                                ->offLabel('Non Aktif'),
                        ])->columns(2),
                    //                    Tabs\Tab::make('Sistem')
                    //                        ->schema([
                    //                            DatePicker::make('app.batas_tgl_input')
                    //                                ->displayFormat(setting('app.format_tgl')),
                    //                        ])->columns(2),
                ]),
        ];
    }
}
