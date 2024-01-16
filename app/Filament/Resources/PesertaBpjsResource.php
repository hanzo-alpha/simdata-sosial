<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PesertaBpjsResource\Pages\ManagePesertaBpjs;
use App\Models\PesertaBpjs;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class PesertaBpjsResource extends Resource
{
    protected static ?string $model = PesertaBpjs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'peserta-bpjs';
    protected static ?string $label = 'Peserta BPJS';
    protected static ?string $pluralLabel = 'Peserta BPJS';
    protected static ?string $navigationLabel = 'Peserta BPJS';
    protected static ?string $navigationParentItem = 'Program BPJS';
    protected static ?string $navigationGroup = 'Program Sosial';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('attachment')
                    ->label('Impor')
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->preserveFilenames()
                    ->previewable(false)
                    ->directory('upload')
                    ->maxSize(5120)
                    ->reorderable()
                    ->appendFiles()
                    ->storeFiles(false)
                    ->acceptedFileTypes([
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'text/csv',
                    ])
                    ->hiddenOn(['edit', 'view']),

                Forms\Components\TextInput::make('nomor_kartu')
                    ->required()
                    ->maxLength(255)
                    ->visibleOn(['edit', 'view']),
                Forms\Components\TextInput::make('nik')
                    ->required()
                    ->maxLength(255)
                    ->visibleOn(['edit', 'view']),
                Forms\Components\TextInput::make('nama_lengkap')
                    ->maxLength(255)
                    ->visibleOn(['edit', 'view']),
                Forms\Components\TextInput::make('alamat')
                    ->maxLength(255)
                    ->visibleOn(['edit', 'view']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_kartu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->wrap()
                    ->searchable(),
            ])
            ->filters([

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
            'index' => ManagePesertaBpjs::route('/'),
        ];
    }
}
