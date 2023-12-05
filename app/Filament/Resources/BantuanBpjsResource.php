<?php

namespace App\Filament\Resources;

use App\Enums\StatusBpjsEnum;
use App\Filament\Resources\BantuanBpjsResource\Pages;
use App\Filament\Resources\BantuanBpjsResource\RelationManagers;
use App\Forms\Components\AlamatForm;
use App\Forms\Components\BantuanForm;
use App\Forms\Components\FamilyForm;
use App\Models\BantuanBpjs;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BantuanBpjsResource extends Resource
{
    protected static ?string $model = BantuanBpjs::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $slug = 'bantuan-bpjs';
    protected static ?string $label = 'Bantuan BPJS';
    protected static ?string $pluralLabel = 'Bantuan BPJS';
    protected static ?string $navigationLabel = 'Bantuan BPJS';
    protected static ?string $navigationGroup = 'Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    FamilyForm::make('familyable'),
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
                            BantuanForm::make('bantuanable'),

                            Forms\Components\Select::make('status_bpjs')
                                ->label('Status BPJS')
                                ->options(StatusBpjsEnum::class)
                                ->default(StatusBpjsEnum::BARU)
                                ->lazy()
                                ->preload(),
                        ])
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('familyable.nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('familyable.nik')
                    ->label('N I K')
                    ->sortable(),
                Tables\Columns\TextColumn::make('familyable.notelp')
                    ->label('No.Telp/WA')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bantuan.nama_bantuan')
                    ->label('Jenis Bantuan')
                    ->listWithLineBreaks()
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_bpjs')
                    ->label('Status BPJS')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListBantuanBpjs::route('/'),
            'create' => Pages\CreateBantuanBpjs::route('/create'),
            'view' => Pages\ViewBantuanBpjs::route('/{record}'),
            'edit' => Pages\EditBantuanBpjs::route('/{record}/edit'),
        ];
    }
}
