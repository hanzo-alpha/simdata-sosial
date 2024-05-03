<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\AlasanEnum;
use App\Filament\Resources\PenggantiRastraResource\Pages;
use App\Models\BantuanRastra;
use App\Models\PenggantiRastra;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class PenggantiRastraResource extends Resource
{
    protected static ?string $model = PenggantiRastra::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?string $slug = 'pengganti-rastra';
    protected static ?string $label = 'Pengganti RASTRA';
    protected static ?string $pluralLabel = 'Pengganti RASTRA';
    protected static ?string $navigationLabel = 'Pengganti RASTRA';
    protected static ?string $navigationParentItem = 'Program Rastra';
    protected static ?string $navigationGroup = 'Program Sosial';

    protected static ?int $navigationSort = 6;

    //    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('bantuan_rastra_id')
                    ->relationship('bantuan_rastra', 'nama_lengkap')
                    ->label('Penerima Manfaat Rastra')
                    ->searchable()
                    ->native(false)
                    ->preload()
                    ->getSearchResultsUsing(fn(string $search): array => BantuanRastra::where(
                        'nama_lengkap',
                        'like',
                        "%{$search}%",
                    )
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('nokk', 'like', "%{$search}%")
                        ->limit(50)->pluck('nik', 'id')->toArray())
                    ->getOptionLabelFromRecordUsing(fn(
                        $record,
                    ) => '<strong>' . $record->nik . '</strong><br>' . $record->nama_lengkap)->allowHtml()
                    ->lazy()
                    ->optionsLimit(15)
                    ->searchingMessage('Sedang mencari...')
                    ->noSearchResultsMessage('Data Tidak ditemukan.')
                    ->required(),
                TextInput::make('nokk_pengganti')
                    ->label('No. KK Pengganti')
                    ->required(),
                TextInput::make('nik_pengganti')
                    ->label('NIK Pengganti')
                    ->required(),
                TextInput::make('nama_pengganti')
                    ->label('Nama Pengganti')
                    ->required(),
                TextInput::make('alamat_pengganti')
                    ->label('Alamat Pengganti')
                    ->required(),
                Select::make('alasan_dikeluarkan')
                    ->searchable()
                    ->options(AlasanEnum::class)
                    ->native(false)
                    ->preload()
                    ->lazy()
                    ->required()
                    ->default(AlasanEnum::PINDAH)
                    ->optionsLimit(15),
                CuratorPicker::make('media_id')
                    ->label('Upload Berita Acara Pengganti')
                    ->relationship('beritaAcara', 'id')
                    ->buttonLabel('Tambah File')
                    ->required()
                    ->preserveFilenames()
                    ->rules(['required'])
                    ->maxSize(2048),
            ])->columns(1)->inlineLabel();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                CuratorColumn::make('beritaAcara')
                    ->label('Berita Acara')
                    ->size(60),
                Tables\Columns\TextColumn::make('nik_pengganti')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => $record->nokk_pengganti)
                    ->label('NIK & NO. KK Baru'),
                Tables\Columns\TextColumn::make('nama_pengganti')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => $record->alamat_pengganti)
                    ->label('NAMA & ALAMAT BARU'),
                Tables\Columns\TextColumn::make('bantuan_rastra.nokk')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => $record->bantuan_rastra?->nik)
                    ->label('NIK & NO.KK Lama'),
                Tables\Columns\TextColumn::make('bantuan_rastra.nama_lengkap')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => $record->bantuan_rastra?->alamat)
                    ->label('NAMA & ALAMAT LAMA'),
                Tables\Columns\TextColumn::make('alasan_dikeluarkan')
                    ->label('Alasan Dikeluarkan')
                    ->alignCenter()
                    ->badge(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ManagePenggantiRastra::route('/'),
        ];
    }
}
