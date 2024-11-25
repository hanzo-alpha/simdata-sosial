<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\AlasanBpjsEnum;
use App\Enums\StatusMutasi;
use App\Filament\Resources\MutasiBpjsResource\Pages;
use App\Models\MutasiBpjs;
use App\Traits\HasInputDateLimit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class MutasiBpjsResource extends Resource
{
    use HasInputDateLimit;

    protected static ?string $model = MutasiBpjs::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';
    protected static ?string $slug = 'mutasi-bpjs';
    protected static ?string $label = 'Mutasi BPJS';
    protected static ?string $pluralLabel = 'Mutasi BPJS';
    protected static ?string $navigationLabel = 'Mutasi BPJS';
    protected static ?string $navigationParentItem = 'Program BPJS';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 7;
    protected static ?string $recordTitleAttribute = 'nama_lengkap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('peserta_bpjs_id')
                    ->label('Nama Peserta BPJS')
                    ->relationship('peserta', 'nama_lengkap')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->optionsLimit(20)
                    ->searchable(['nomor_kartu', 'nik', 'nama_lengkap'])
                    ->noSearchResultsMessage('Data peserta BPJS tidak ditemukan')
                    ->searchPrompt('Ketikkan nomor kartu, nik, atau nama untuk mencari')
                    ->native(false)
                    ->getOptionLabelFromRecordUsing(
                        fn($record) => "<strong>{$record->nama_lengkap}</strong> | NIK: " . $record->nik . ' | No. Kartu : ' . $record->nomor_kartu,
                    )
                    ->allowHtml()
                    ->columnSpanFull(),

                Forms\Components\Select::make('alasan_mutasi')
                    ->enum(AlasanBpjsEnum::class)
                    ->options(AlasanBpjsEnum::class)
                    ->native(false)
                    ->required()
                    ->preload()
                    ->lazy(),

                Forms\Components\Select::make('periode_bulan')
                    ->options(list_bulan())
                    ->native(false)
                    ->required()
                    ->preload()
                    ->lazy(),

                Forms\Components\TextInput::make('keterangan')
                    ->dehydrated(),

                Forms\Components\ToggleButtons::make('status_mutasi')
                    ->label('Status Peserta')
                    ->options(StatusMutasi::class)
                    ->inline()
                    ->default(StatusMutasi::MUTASI),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada mutasi BPJS')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Mutasi BPJS')
                    ->icon('heroicon-m-plus')
                    ->disabled(fn(): bool => cek_batas_input(setting('app.batas_tgl_input_mutasi')))
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('peserta.nama_lengkap')
                    ->label('Nama Peserta')
                    ->sortable()
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alasan_mutasi')
                    ->label('Alasan Mutasi')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('periode_bulan')
                    ->label('Periode Bulan')
                    ->formatStateUsing(fn($state) => bulan_to_string($state))
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_mutasi')
                    ->label('Status Peserta')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_mutasi')
                    ->label('Status Mutasi')
                    ->options(StatusMutasi::class)
                    ->native(false)
                    ->preload(),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->hiddenFilterIndicators()
            ->deferLoading()
//            ->deferFilters()
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
        if (auth()->user()->hasRole(superadmin_admin_roles())) {
            return parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        }

        return parent::getEloquentQuery()
//            ->where('kelurahan', auth()->user()->instansi_id)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
