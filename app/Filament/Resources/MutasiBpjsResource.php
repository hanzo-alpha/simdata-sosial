<?php

namespace App\Filament\Resources;

use App\Enums\AlasanEnum;
use App\Filament\Resources\MutasiBpjsResource\Pages\ManageMutasiBpjs;
use App\Filament\Resources\MutasiBpjsResource\RelationManagers;
use App\Models\MutasiBpjs;
use App\Models\PesertaBpjs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Wallo\FilamentSelectify\Components\ToggleButton;

class MutasiBpjsResource extends Resource
{
    protected static ?string $model = MutasiBpjs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'mutasi-bpjs';
    protected static ?string $label = 'Mutasi BPJS';
    protected static ?string $pluralLabel = 'Mutasi BPJS';
    protected static ?string $navigationLabel = 'Mutasi BPJS';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('peserta_bpjs_id')
                    ->label('Nama Peserta BPJS')
                    ->relationship('peserta', 'nama_lengkap')
                    ->live(onBlur: true)
                    ->required()
                    ->minItems(1)
                    ->optionsLimit(20)
                    ->searchable(['nomor_kartu', 'nik', 'nama_lengkap'])
                    ->noSearchResultsMessage('Data peserta BPJS tidak ditemukan')
                    ->searchPrompt('Cari peserta berdasarkan nomor kartu, nik, atau nama')
                    ->native(false)
                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                        return "<strong>{$record->nama_lengkap}</strong> | NIK: " . (string) ($record->nik);
                    })->allowHtml()
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, $state) {
                        $peserta = PesertaBpjs::find($state);
                        $set('nomor_kartu', $peserta->nomor_kartu);
                        $set('nik', $peserta->nik);
                        $set('nama_lengkap', $peserta->nama_lengkap);
                        $set('alamat_lengkap', $peserta->alamat);
                    })
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('nomor_kartu')
                    ->disabled()
                    ->maxLength(13),
                Forms\Components\TextInput::make('nik')
                    ->disabled()
                    ->maxLength(16),
                Forms\Components\TextInput::make('nama_lengkap')
                    ->disabled()
                    ->maxLength(150),
                Forms\Components\Textarea::make('alamat_lengkap')
                    ->disabled()
                    ->maxLength(65535)
                    ->autosize(),
                Forms\Components\Textarea::make('keterangan')
                    ->maxLength(65535)
                    ->autosize()
                    ->columnSpanFull(),
                Forms\Components\Select::make('alasan_mutasi')
                    ->options(AlasanEnum::class)
                    ->required()
                    ->preload()
                    ->lazy(),
                ToggleButton::make('status_mutasi')
                    ->label('Status Aktif')
                    ->offColor('danger')
                    ->onColor('primary')
                    ->offLabel('Non Aktif')
                    ->onLabel('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('peserta.nama_lengkap')
                    ->label('Nama Peserta BPJS')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_kartu')
                    ->label('Nomor Kartu')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alasan_mutasi')
                    ->label('Alasan Mutasi')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_mutasi')
                    ->label('Status Aktif')
                    ->badge()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => ManageMutasiBpjs::route('/'),
        ];
    }
}