<?php

namespace App\Filament\Resources;

use App\Enums\StatusPenandatangan;
use App\Filament\Resources\PenandatanganResource\Pages;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Penandatangan;
use Coolsam\SignaturePad\Forms\Components\Fields\SignaturePad;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PenandatanganResource extends Resource
{
    protected static ?string $model = Penandatangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'penandatangan';
    protected static ?string $label = 'Penandatangan';
    protected static ?string $pluralLabel = 'Penandatangan';
    protected static ?string $navigationLabel = 'Penandatangan';
    //    protected static ?string $navigationParentItem = 'Tipe PPKS';
    protected static ?string $navigationGroup = 'Dashboard Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kode_kecamatan')
                    ->options(Kecamatan::where('kabupaten_code', setting('app.kodekab'))->pluck('name', 'code'))
                    ->searchable()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, $state): void {
                        //                        $kelurahan = Kelurahan::where('kecamatan_code', $state)
                        //                            ->first()->code;
                        //                        if (null === $kelurahan) {
                        //                            $set('kode_instansi', null);
                        //                        }
                        //                        $set('kode_instansi', $kelurahan);
                        $set('kode_instansi', null);
                    })
                    ->required(),
                Select::make('kode_instansi')
                    ->options(function (Get $get) {
                        $kelurahan = Kelurahan::where('kecamatan_code', $get('kode_kecamatan'))->pluck('name', 'code');
                        return $kelurahan ?? [];
                    })
                    ->searchable()
                    ->required(),
                TextInput::make('nama_penandatangan')
                    ->required(),
                TextInput::make('nip')
                    ->required(),
                TextInput::make('jabatan')
                    ->required(),

                ToggleButtons::make('status_penandatangan')
                    ->label('Status')
                    ->inline()
                    ->options(StatusPenandatangan::class)
                    ->default(StatusPenandatangan::AKTIF)
                    ->required(),

                SignaturePad::make('signature')
                    ->label('Tanda Tangan')
                    ->columnSpanFull()
//                    ->backgroundColor('white')
//                    ->penColor('blue')
//                    ->strokeMinDistance(2.0)
//                    ->strokeMaxWidth(2.5)
//                    ->strokeMinWidth(1.0) // set the minimum width of the pen stroke
//                    ->strokeDotSize(2.0) // set the stroke dot size.
                    ->hideDownloadButtons()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->poll()
            ->columns([
                Tables\Columns\TextColumn::make('kode_instansi')
                    ->label('Instansi')
                    ->sortable()
//                    ->description(fn($record): string => 'Kec. '.Kecamatan::where('code',
//                            $record->kode_kecamatan)->first()->name)
                    ->formatStateUsing(fn($state): string => Kelurahan::where('code', $state)->first()?->name ?? '-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_penandatangan')
                    ->label('Nama Penandatangan')
                    ->sortable()
                    ->searchable(),
                //                    ->description(fn($record): string => $record->jabatan),
                Tables\Columns\TextColumn::make('nip')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_penandatangan')
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->alignCenter()
                    ->badge(),
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
            'index' => Pages\ManagePenandatangans::route('/'),
        ];
    }
}
