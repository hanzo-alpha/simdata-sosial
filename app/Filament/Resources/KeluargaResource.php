<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeluargaResource\Pages;
use App\Filament\Resources\KeluargaResource\RelationManagers;
use App\Models\Keluarga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KeluargaResource extends Resource
{
    protected static ?string $model = Keluarga::class;

    protected static ?string $slug = 'keluarga';
    protected static ?string $label = 'Keluarga';
    protected static ?string $pluralLabel = 'Keluarga';
    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Data Pribadi')
                        ->schema([
                            Forms\Components\TextInput::make('nokk')
                                ->label('No. Kartu Keluarga')
                                ->autofocus()
                                ->required()
                                ->maxLength(20),
                            Forms\Components\TextInput::make('nik')
                                ->label('N I K')
                                ->required()
                                ->maxLength(20),
                            Forms\Components\TextInput::make('nama_lengkap')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('notelp')
                                ->label('$label')
                                ->tel()
                                ->required()
                                ->maxLength(18),
                            Forms\Components\TextInput::make('tempat_lahir')
                                ->label('Tempat Lahir')
                                ->required()
                                ->maxLength(50),
                            Forms\Components\DatePicker::make('tgl_lahir')
                                ->label('Tanggal Lahir')
                                ->required(),

                        ])->columns(2),
                    Forms\Components\Wizard\Step::make('Data Lainnya')
                        ->schema([
                            Forms\Components\Select::make('alamat_id')
                                ->relationship('alamat', 'id')
                                ->required(),
                            Forms\Components\TextInput::make('jenis_bantuan_id')
                                ->required()
                                ->numeric(),
                            Forms\Components\TextInput::make('pendidikan_terakhir_id')
                                ->required()
                                ->numeric(),
                            Forms\Components\TextInput::make('hubungan_keluarga_id')
                                ->required()
                                ->numeric(),
                            Forms\Components\TextInput::make('jenis_pekerjaan_id')
                                ->required()
                                ->numeric(),

                            Forms\Components\TextInput::make('nama_ibu_kandung')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Toggle::make('status_kawin'),
                            Forms\Components\Toggle::make('jenis_kelamin'),
                            Forms\Components\Toggle::make('status_keluarga'),
                        ])->columns(2)
                ]),

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('alamat.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_bantuan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pendidikan_terakhir_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hubungan_keluarga_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_pekerjaan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nokk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('notelp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_ibu_kandung')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status_kawin')
                    ->boolean(),
                Tables\Columns\IconColumn::make('jenis_kelamin')
                    ->boolean(),
                Tables\Columns\IconColumn::make('status_keluarga')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKeluarga::route('/'),
            'create' => Pages\CreateKeluarga::route('/create'),
            'edit' => Pages\EditKeluarga::route('/{record}/edit'),
        ];
    }
}
