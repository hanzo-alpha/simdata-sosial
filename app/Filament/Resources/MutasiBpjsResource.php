<?php

namespace App\Filament\Resources;

use App\Enums\AlasanEnum;
use App\Enums\JenisKelaminEnum;
use App\Filament\Resources\MutasiBpjsResource\Pages\ManageMutasiBpjs;
use App\Filament\Resources\UsulanMutasiTmtResource\RelationManagers;
use App\Models\MutasiBpjs;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
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

//    protected static bool $shouldRegisterNavigation = false;

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
//                    ->visibleOn(['edit', 'view'])
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik_tmt')
                    ->required()
//                    ->visibleOn(['edit', 'view'])
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_lengkap')
                    ->required()
//                    ->visibleOn(['edit', 'view'])
                    ->maxLength(255),
                Forms\Components\Select::make('jenis_kelamin')
                    ->options(JenisKelaminEnum::class)
                    ->preload()
//                    ->visibleOn(['edit', 'view'])
                    ->lazy(),
                Forms\Components\TextInput::make('nomor_kartu')
//                    ->visibleOn(['edit', 'view'])
                    ->maxLength(255),
                Forms\Components\Select::make('alasan_mutasi')
                    ->options(AlasanEnum::class)
                    ->preload()
//                    ->visibleOn(['edit', 'view'])
                    ->lazy(),
                Forms\Components\Textarea::make('alamat')
                    ->maxLength(65535)
//                    ->visibleOn(['edit', 'view'])
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('keterangan')
                    ->maxLength(65535)
//                    ->visibleOn(['edit', 'view'])
                    ->columnSpanFull(),
                ToggleButton::make('status_mutasi')
                    ->label('Status Aktif')
                    ->offColor('danger')
                    ->onColor('primary')
                    ->offLabel('Non Aktif')
                    ->onLabel('Aktif')
//                    ->visibleOn(['edit', 'view'])
                    ->default(true),
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
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->badge(),
                Tables\Columns\TextColumn::make('nomor_kartu')
                    ->label('Nomor Kartu')
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
