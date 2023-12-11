<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsulanPengaktifanTmtResource\Pages;
use App\Filament\Resources\UsulanPengaktifanTmtResource\RelationManagers;
use App\Models\UsulanPengaktifanTmt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UsulanPengaktifanTmtResource extends Resource
{
    protected static ?string $model = UsulanPengaktifanTmt::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'usulan-pengaktifan-tmt';
    protected static ?string $label = 'Usulan Pengaktifan TMT';
    protected static ?string $pluralLabel = 'Usulan Pengaktifan TMT';
    protected static ?string $navigationLabel = 'Usulan Pengaktifan TMT';
    protected static ?string $navigationGroup = 'Bantuan BPJS';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                FileUpload::make('attachment')
//                    ->label('Impor')
//                    ->hiddenLabel()
//                    ->columnSpanFull()
//                    ->preserveFilenames()
//                    ->previewable(false)
//                    ->directory('upload')
//                    ->maxSize(5120)
//                    ->reorderable()
//                    ->appendFiles()
//                    ->storeFiles(false)
//                    ->acceptedFileTypes([
//                        'application/vnd.ms-excel',
//                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
//                        'text/csv'
//                    ])
//                    ->hiddenOn(['edit', 'view']),
                Forms\Components\TextInput::make('nokk_tmt')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('nik_tmt')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('nama_lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->maxLength(100),
                Forms\Components\DatePicker::make('tgl_lahir'),
                Forms\Components\Toggle::make('jenis_kelamin'),
                Forms\Components\Toggle::make('status_nikah'),
                Forms\Components\Textarea::make('alamat')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('nort')
                    ->maxLength(255),
                Forms\Components\TextInput::make('norw')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kodepos')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kecamatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kelurahan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('dusun')
                    ->maxLength(255),
                Forms\Components\Toggle::make('status_aktif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nokk_tmt')
                    ->label('No. KK')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_tmt')
                    ->label('NIK')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->description(fn($record) => $record->tgl_lahir->format('d/M/Y'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->label('Tgl. Lahir')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge(),
                Tables\Columns\TextColumn::make('status_nikah')
                    ->label('Status Nikah')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge(),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->description(function ($record) {
                        $rt = $record['nort'];
                        $rw = $record['norw'];
                        $dusun = $record['dusun'];
                        $kodepos = $record['kodepos'];
                        $kec = $record->kec?->name;
                        $kel = $record->kel?->name;
                        return $dusun . ' ' . 'RT.' . $rt . '/' . 'RW.' . $rw . ' ' . $kec . ', ' . $kel . ', ' . $kodepos;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('kec.kecamatan')
                    ->label('Kecamatan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('kel.kelurahan')
                    ->label('Kelurahan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('bulan')
                    ->date('M'),
                Tables\Columns\TextColumn::make('dusun')
                    ->label('Dusun')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_aktif')
                    ->label('Status Aktif')
                    ->sortable()
                    ->toggleable()
                    ->badge(),
                Tables\Columns\TextColumn::make('status_bpjs')
                    ->label('Status BPJS')
                    ->sortable()
                    ->toggleable()
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsulanPengaktifanTmt::route('/'),
        ];
    }
}
