<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\AlasanBpjsEnum;
use App\Enums\StatusMutasi;
use App\Filament\Resources\MutasiBpjsResource\Pages;
use App\Models\MutasiBpjs;
use App\Traits\HasInputDateLimit;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Awcodes\Curator\PathGenerators\UserPathGenerator;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

final class MutasiBpjsResource extends Resource
{
    use HasInputDateLimit;

    protected static ?string $model = MutasiBpjs::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-path-rounded-square';
    protected static ?string $slug = 'mutasi-bpjs';
    protected static ?string $label = 'Mutasi BPJS';
    protected static ?string $pluralLabel = 'Mutasi BPJS';
    protected static ?string $navigationLabel = 'Mutasi BPJS';
    protected static ?string $navigationParentItem = 'Program BPJS';
    protected static string|UnitEnum|null $navigationGroup = 'Program Bantuan';
    protected static ?int $navigationSort = 7;
    protected static ?string $recordTitleAttribute = 'nama_lengkap';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\Select::make('peserta_bpjs_id')
                            ->label('Nama Peserta BPJS')
                            ->relationship(
                                name: 'peserta',
                                titleAttribute: 'nama_lengkap',
                                //                        modifyQueryUsing: function ($query) {
                                //                            if (auth()->user()->hasRole(superadmin_admin_roles())) {
                                //                                return $query;
                                //                            }
                                //                            return $query->with(['kel','kec'])->whereHas('kel', function ($query): void {
                                //                                $query->where('code', auth()->user()->instansi_id);
                                //                            });
                                //                        },
                            )
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->optionsLimit(20)
                            ->searchable(['nomor_kartu', 'nik', 'nama_lengkap'])
                            ->noSearchResultsMessage('Data peserta BPJS tidak ditemukan')
                            ->searchPrompt('Ketikkan nomor kartu, nik, atau nama untuk mencari')
                            ->native(false)
                            ->getOptionLabelFromRecordUsing(
                                fn(
                                $record,
                            ) => "<strong>{$record->nama_lengkap}</strong> | NIK: " . $record->nik . ' | No. Kartu : ' . $record->nomor_kartu,
                            )
                            ->allowHtml()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('alasan_mutasi')
                            ->enum(AlasanBpjsEnum::class)
                            ->options(AlasanBpjsEnum::class)
                            ->native(false)
                            ->required()
                            ->live(onBlur: true)
                            ->preload()
                            ->lazy(),

                        Forms\Components\Select::make('periode_bulan')
                            ->options(list_bulan())
                            ->native(false)
                            ->required()
                            ->preload()
                            ->lazy(),

                        Forms\Components\Select::make('periode_tahun')
                            ->options(list_tahun())
                            ->native(false)
                            ->required()
                            ->preload()
                            ->lazy(),

                        Forms\Components\TextInput::make('keterangan')
                            ->dehydrated(),

                        Forms\Components\TextInput::make('no_surat_kematian')
                            ->label('No. Surat Kematian')
                            ->helperText('Aktif jika alasan mutasi meninggal.')
                            ->disabled(fn(callable $get) => AlasanBpjsEnum::MENINGGAL !== $get('alasan_mutasi'))
                            ->visible(fn(callable $get) => AlasanBpjsEnum::MENINGGAL === $get('alasan_mutasi'))
                            ->nullable(),

                        Forms\Components\ToggleButtons::make('status_mutasi')
                            ->label('Status Mutasi')
                            ->options(StatusMutasi::class)
                            ->inline()
                            ->default(StatusMutasi::MUTASI),

                        CuratorPicker::make('media_id')
                            ->label('Lampiran')
                            ->outlined(false)
                            ->color('warning')
                            ->pathGenerator(UserPathGenerator::class)
                            ->buttonLabel('Unggah Bukti')
                            ->relationship('lampiran', 'id'),
                    ])->inlineLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada mutasi BPJS')
            ->emptyStateActions([
                Actions\CreateAction::make()
                    ->label('Tambah Mutasi BPJS')
                    ->icon('heroicon-m-plus')
                    ->disabled(fn(): bool => cek_batas_input(setting('app.batas_tgl_input_mutasi')))
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('peserta.nama_lengkap')
                    ->label('Nama Peserta')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alasan_mutasi')
                    ->label('Alasan Mutasi')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('periode_bulan')
                    ->label('Periode')
                    ->formatStateUsing(fn(
                        $record,
                    ) => bulan_to_string($record->periode_bulan) . ' - ' . $record->periode_tahun)
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_mutasi')
                    ->label('Status Mutasi')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                CuratorColumn::make('media_id')
                    ->label('Lampiran')
                    ->toggledHiddenByDefault()
                    ->size(40),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('periode_bulan')
                    ->label('Periode Bulan')
                    ->options(list_bulan())
                    ->native(false)
                    ->preload(),
                Tables\Filters\SelectFilter::make('periode_tahun')
                    ->label('Periode Tahun')
                    ->options(list_tahun())
                    ->native(false)
                    ->preload(),
                Tables\Filters\SelectFilter::make('status_mutasi')
                    ->label('Status Mutasi')
                    ->options(StatusMutasi::class)
                    ->native(false)
                    ->preload(),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->hiddenFilterIndicators()
            ->deferLoading()
            ->deferFilters()
            ->actions([
                Actions\EditAction::make()
                    ->using(function (Model $record, array $data): Model {
                        $data['nomor_kartu'] = $record->peserta->nomor_kartu;
                        $data['nik'] = $record->peserta->nik;
                        $data['nama_lengkap'] = $record->peserta->nama_lengkap;
                        $data['alamat_lengkap'] = $record->peserta->alamat;
                        $record->update($data);

                        return $record;
                    }),
                Actions\DeleteAction::make(),
                Actions\ForceDeleteAction::make(),
                Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                    Actions\ForceDeleteBulkAction::make(),
                    Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMutasiBpjs::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        //        if (auth()->user()->hasRole(superadmin_admin_roles())) {
        //            return parent::getEloquentQuery()
        //                ->withoutGlobalScopes([
        //                    SoftDeletingScope::class,
        //                ]);
        //        }

        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
