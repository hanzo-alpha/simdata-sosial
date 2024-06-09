<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\AlasanEnum;
use App\Filament\Resources\MutasiBpjsResource\Pages;
use App\Models\MutasiBpjs;
use App\Models\PesertaBpjs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Wallo\FilamentSelectify\Components\ToggleButton;

final class MutasiBpjsResource extends Resource
{
    protected static ?string $model = MutasiBpjs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'mutasi-bpjs';
    protected static ?string $label = 'Mutasi BPJS';
    protected static ?string $pluralLabel = 'Mutasi BPJS';
    protected static ?string $navigationLabel = 'Mutasi BPJS';
    protected static ?string $navigationParentItem = 'Program BPJS';
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
                    ->optionsLimit(20)
                    ->searchable(['nomor_kartu', 'nik', 'nama_lengkap'])
                    ->noSearchResultsMessage('Data peserta BPJS tidak ditemukan')
                    ->searchPrompt('Ketikkan nomor kartu, nik, atau nama untuk mencari')
                    ->native(false)
                    ->getOptionLabelFromRecordUsing(fn(
                        $record,
                    ) => "<strong>{$record->nama_lengkap}</strong> | NIK: " . (string) ($record->nik))->allowHtml()
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, $state): void {
                        $peserta = PesertaBpjs::find($state);
                        if (isset($peserta) && $peserta->count() > 0) {
                            $set('nomor_kartu', $peserta->nomor_kartu);
                            $set('nik', $peserta->nik);
                            $set('nama_lengkap', $peserta->nama_lengkap);
                            $set('alamat_lengkap', $peserta->alamat);
                        } else {
                            $set('nomor_kartu', null);
                            $set('nik', null);
                            $set('nama_lengkap', null);
                            $set('alamat_lengkap', null);
                        }
                    })
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('nomor_kartu')
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(13),
                Forms\Components\TextInput::make('nik')
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(16),
                Forms\Components\TextInput::make('nama_lengkap')
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(150),
                Forms\Components\Textarea::make('alamat_lengkap')
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(65535)
                    ->autosize(),
                Forms\Components\Textarea::make('keterangan')
                    ->maxLength(65535)
                    ->autosize()
                    ->dehydrated()
                    ->columnSpanFull(),
                Forms\Components\Select::make('alasan_mutasi')
                    ->options(AlasanEnum::class)
                    ->required()
                    ->preload()
                    ->lazy(),
                ToggleButton::make('status_mutasi')
                    ->label('Status Peserta')
                    ->offColor('danger')
                    ->onColor('primary')
                    ->offLabel('BATAL MUTASI')
                    ->onLabel('DI MUTASI')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada mutasi BPJS')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Mutasi BPJS')
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
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
                Tables\Columns\TextColumn::make('alasan_mutasi')
                    ->label('Alasan Mutasi')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_mutasi')
                    ->label('Status Peserta')
                    ->badge()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([

            ])
            ->actions([
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
            'index' => Pages\ManageMutasiBpjs::route('/'),
        ];
    }
}
