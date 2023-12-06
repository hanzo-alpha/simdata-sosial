<?php

namespace App\Filament\Resources;

use App\Enums\StatusRastra;
use App\Filament\Resources\BantuanRastraResource\Pages;
use App\Filament\Resources\BantuanRastraResource\RelationManagers;
use App\Forms\Components\AlamatForm;
use App\Forms\Components\FamilyForm;
use App\Models\BantuanRastra;
use App\Models\JenisBantuan;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
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
                    FamilyForm::make('family'),
                    Section::make('Data Alamat')
                        ->schema([
                            AlamatForm::make('alamat')
                        ]),
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
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
//                            BantuanForm::make('bantuan'),

                            Forms\Components\TextInput::make('location')
                                ->label('Lokasi'),

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
                        ])
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('family.nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('family.nik')
                    ->label('N I K')
                    ->sortable(),
                Tables\Columns\TextColumn::make('family.notelp')
                    ->label('No.Telp/WA')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bantuan.jenis_bantuan_id')
                    ->label('Jenis Bantuan')
                    ->formatStateUsing(fn($record) => JenisBantuan::find($record->bantuan->jenis_bantuan_id)?->alias)
//                    ->listWithLineBreaks()
                    ->badge()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status_rastra')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListBantuanRastras::route('/'),
            'create' => Pages\CreateBantuanRastra::route('/create'),
            'view' => Pages\ViewBantuanRastra::route('/{record}'),
            'edit' => Pages\EditBantuanRastra::route('/{record}/edit'),
        ];
    }
}
