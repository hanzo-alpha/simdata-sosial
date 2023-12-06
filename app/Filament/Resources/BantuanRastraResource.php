<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusKawinEnum;
use App\Enums\StatusRastra;
use App\Enums\StatusVerifikasiEnum;
use App\Filament\Resources\BantuanRastraResource\Pages;
use App\Filament\Resources\BantuanRastraResource\RelationManagers;
use App\Forms\Components\AlamatForm;
use App\Models\BantuanRastra;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Wallo\FilamentSelectify\Components\ToggleButton;

class BantuanRastraResource extends Resource
{
    protected static ?string $model = BantuanRastra::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $slug = 'bantuan-rastra';
    protected static ?string $label = 'Bantuan Rastra';
    protected static ?string $pluralLabel = 'Bantuan Rastra';
    protected static ?string $navigationGroup = 'Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Data Keluarga')
                        ->schema([
                            TextInput::make('dtks_id')
                                ->maxLength(36)
                                ->hidden()
                                ->dehydrated()
                                ->default(\Str::uuid()->toString()),
                            TextInput::make('nokk')
                                ->label('No. Kartu Keluarga (KK)')
                                ->required()
                                ->maxLength(20),
                            TextInput::make('nik')
                                ->label('N I K')
                                ->required()
                                ->maxLength(20),
                            TextInput::make('nama_lengkap')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('nama_ibu_kandung')
                                ->label('Nama Ibu Kandung')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('tempat_lahir')
                                ->label('Tempat Lahir')
                                ->required()
                                ->maxLength(50),
                            DatePicker::make('tgl_lahir')
                                ->displayFormat('d/M/Y')
                                ->label('Tgl. Lahir')
                                ->required(),
                            TextInput::make('notelp')
                                ->label('No. Telp/WA')
                                ->required()
                                ->maxLength(18),

                            Select::make('jenis_kelamin')
                                ->options(JenisKelaminEnum::class)
                                ->default(JenisKelaminEnum::LAKI),

                            Select::make('jenis_pekerjaan_id')
                                ->relationship('jenis_pekerjaan', 'nama_pekerjaan')
                                ->searchable()
                                ->optionsLimit(15)
                                ->default(6)
                                ->preload(),
                            Select::make('pendidikan_terakhir_id')
                                ->relationship('pendidikan_terakhir', 'nama_pendidikan')
                                ->searchable()
                                ->default(5)
                                ->optionsLimit(15)
                                ->preload(),
                            Select::make('hubungan_keluarga_id')
                                ->relationship('hubungan_keluarga', 'nama_hubungan')
                                ->searchable()
                                ->default(7)
                                ->optionsLimit(15)
                                ->preload(),
                            Select::make('status_kawin')
                                ->options(StatusKawinEnum::class)
                                ->default(StatusKawinEnum::KAWIN)
                                ->preload(),


                        ])->columns(2),
                    Section::make('Data Alamat')
                        ->schema([
                            AlamatForm::make('alamat')
                        ]),
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Section::make('Status')
                        ->schema([
                            Select::make('jenis_bantuan_id')
                                ->required()
                                ->searchable()
                                ->disabled()
                                ->relationship(
                                    name: 'jenis_bantuan',
                                    titleAttribute: 'alias',
                                    modifyQueryUsing: fn(Builder $query) => $query->whereNotIn('id', [1, 2])
                                )
                                ->default(4)
                                ->dehydrated(),

                            Select::make('status_verifikasi')
                                ->label('Status Verifikasi')
                                ->options(StatusVerifikasiEnum::class)
                                ->default(StatusVerifikasiEnum::UNVERIFIED)
                                ->preload(),

                            Forms\Components\Select::make('status_rastra')
                                ->label('Status Rastra')
                                ->options(StatusRastra::class)
                                ->default(StatusRastra::BARU)
                                ->lazy()
                                ->preload(),

                            ToggleButton::make('status_aktif')
                                ->label('Status Aktif')
                                ->offColor('danger')
                                ->onColor('primary')
                                ->offLabel('Non Aktif')
                                ->onLabel('Aktif')
                                ->default(true),
                        ]),

                    Forms\Components\Section::make('Verifikasi')
                        ->schema([
                            Forms\Components\FileUpload::make('bukti_foto')
                                ->label('Unggah Foto Rumah')
                                ->getUploadedFileNameForStorageUsing(
                                    fn(TemporaryUploadedFile $file
                                    ): string => (string) str($file->getClientOriginalName())
                                        ->prepend(date('d-m-Y-H-i-s') . '-'),
                                )
                                ->preserveFilenames()
                                ->multiple()
                                ->reorderable()
                                ->appendFiles()
                                ->openable()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->helperText('maks. 2MB')
                                ->maxFiles(3)
                                ->maxSize(2048)
                                ->columnSpanFull()
                                ->imagePreviewHeight('250')
                                ->previewable(false)
                                ->image()
                                ->imageEditor()
                                ->imageEditorAspectRatios([
                                    '16:9',
                                    '4:3',
                                    '1:1',
                                ]),
                        ])
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')
                    ->label('N I K')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nokk')
                    ->label('No. KK')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('notelp')
                    ->label('No.Telp/WA')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_bantuan.alias')
                    ->label('Jenis Bantuan')
                    ->badge()
                    ->color(fn($record): string => $record->jenis_bantuan->warna)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_rastra')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBantuanRastras::route('/'),
            'create' => Pages\CreateBantuanRastra::route('/create'),
            'view' => Pages\ViewBantuanRastra::route('/{record}'),
            'edit' => Pages\EditBantuanRastra::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
