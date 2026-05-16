<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPpksResource\RelationManagers;

use App\Enums\StatusPenyaluran;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenyaluransRelationManager extends RelationManager
{
    protected static string $relationship = 'penyalurans';

    protected static ?string $title = 'Riwayat Penyaluran';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    DateTimePicker::make('tgl_penyerahan')
                        ->label('Tgl. Penyerahan')
                        ->displayFormat('d/M/Y H:i:s')
                        ->default(now())
                        ->required(),
                    Select::make('status_penyaluran')
                        ->label('Status Penyaluran')
                        ->options(StatusPenyaluran::class)
                        ->default(StatusPenyaluran::TERSALURKAN)
                        ->required(),
                ]),
                Geocomplete::make('lokasi')
                    ->required()
                    ->countries(['id'])
                    ->updateLatLng()
                    ->geocodeOnLoad()
                    ->geolocate()
                    ->columnSpanFull()
                    ->reverseGeocode([
                        'country' => '%C',
                        'city' => '%L',
                        'city_district' => '%D',
                        'zip' => '%z',
                        'state' => '%A1',
                        'street' => '%S %n',
                    ]),
                Grid::make(2)->schema([
                    TextInput::make('lat')->label('Latitude')->disabled()->dehydrated(),
                    TextInput::make('lng')->label('Longitude')->disabled()->dehydrated(),
                ]),
                FileUpload::make('foto_penyerahan')
                    ->label('Foto Penyerahan')
                    ->disk('public')
                    ->directory('penyaluran-ppks')
                    ->image()
                    ->required()
                    ->multiple()
                    ->maxFiles(2)
                    ->columnSpanFull(),
                TextInput::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tgl_penyerahan')
            ->columns([
                TextColumn::make('tgl_penyerahan')
                    ->label('Tanggal')
                    ->dateTime('d/M/Y H:i')
                    ->sortable(),
                TextColumn::make('status_penyaluran')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->limit(50),
                Tables\Columns\ImageColumn::make('foto_penyerahan')
                    ->label('Foto')
                    ->circular()
                    ->stacked(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->icon('heroicon-m-plus')
                    ->disabled(fn() => cek_batas_input(setting('app.batas_tgl_input_ppks')))
                    ->mutateDataUsing(function (array $data): array {
                        $data['nokk'] = $this->getOwnerRecord()->nokk;
                        $data['nik'] = $this->getOwnerRecord()->nik;
                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
                Action::make('pdf')
                    ->label('Print')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(Model $record) => route('cetak-dokumentasi.ppks', ['id' => $record, 'm' => get_class($record)]))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
