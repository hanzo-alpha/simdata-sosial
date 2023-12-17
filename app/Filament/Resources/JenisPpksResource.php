<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisPpksResource\Pages;
use App\Filament\Resources\JenisPpksResource\RelationManagers;
use App\Models\JenisPpks;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JenisPpksResource extends Resource
{
    protected static ?string $model = JenisPpks::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $slug = 'jenis-ppks';
    protected static ?string $label = 'Jenis PPKS';
    protected static ?string $pluralLabel = 'Jenis PPKS';
    protected static ?string $navigationLabel = 'Jenis PPKS';
    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_ppks')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alias')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('sub_jenis_ppks')
                    ->label('Kriteria PPKS')
                    ->relationship()
                    ->simple(
                        Forms\Components\TextInput::make('nama_sub_jenis')
                            ->label('Nama Kriteria')
                            ->required()
                    )
                    ->addActionLabel('Tambah Kriteria PPKS')
                    ->reorderableWithButtons()
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BadgeableColumn::make('nama_ppks')
                    ->label('Jenis PPKS')
                    ->suffixBadges([
                        Badge::make('alias')
                            ->label(fn($record) => $record->alias)
                            ->color('success')
                    ])
                    ->sortable()
                    ->searchable(),
//                Tables\Columns\TextColumn::make('nama_ppks')
//                    ->label('Nama PPKS')
//                    ->searchable()
//                    ->sortable(),
//                    ->description(fn($record) => $record->deskripsi),
//                Tables\Columns\TextColumn::make('alias')
//                    ->sortable()
//                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_jenis_ppks.nama_sub_jenis')
                    ->label('Kriteria PPKS')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->badge()
                    ->color('gray')
//                    ->inline()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
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
            'index' => Pages\ManageJenisPpks::route('/'),
        ];
    }
}
