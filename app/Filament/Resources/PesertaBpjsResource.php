<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PesertaBpjsResource\Pages\ManagePesertaBpjs;
use App\Imports\ImportPesertaBpjs;
use App\Models\PesertaBpjs;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

final class PesertaBpjsResource extends Resource
{
    protected static ?string $model = PesertaBpjs::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $slug = 'peserta-bpjs';
    protected static ?string $label = 'Peserta BPJS';
    protected static ?string $pluralLabel = 'Peserta BPJS';
    protected static ?string $navigationLabel = 'Peserta BPJS';
    protected static ?string $navigationParentItem = 'Program BPJS';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?string $recordTitleAttribute = 'nama_lengkap';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('attachment')
                    ->label('Impor')
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->previewable(false)
                    ->directory('upload')
                    ->maxSize(5120)
                    ->reorderable()
                    ->appendFiles()
                    ->storeFiles(false)
                    ->acceptedFileTypes([
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ])
                    ->hiddenOn(['edit', 'view']),

                Forms\Components\TextInput::make('nomor_kartu')
                    ->required()
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                        $livewire->validateOnly($component->getStatePath());
                    })
                    ->minLength(14)
                    ->maxLength(14)
                    ->visibleOn(['edit', 'view']),
                Forms\Components\TextInput::make('nik')
                    ->required()
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                        $livewire->validateOnly($component->getStatePath());
                    })
                    ->minLength(16)
                    ->maxLength(16)
                    ->visibleOn(['edit', 'view']),
                Forms\Components\TextInput::make('nama_lengkap')
                    ->maxLength(255)
                    ->visibleOn(['edit', 'view']),
                Forms\Components\TextInput::make('alamat')
                    ->maxLength(255)
                    ->visibleOn(['edit', 'view']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->poll()
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada peserta BPJS')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Unggah Data')
                    ->modalHeading('Unggah Data Peserta BPJS')
                    ->modalDescription('Unggah Peserta BPJS ke database')
                    ->modalSubmitActionLabel('Unggah')
                    ->modalIcon('heroicon-o-arrow-down-tray')
                    ->createAnother(false)
                    ->action(function (array $data): void {
                        Excel::import(new ImportPesertaBpjs(), $data['attachment'], 'public');
                        //                        $deleteAll = PesertaBpjs::query()->delete();
                        //                        if ($deleteAll) {
                        //                            Excel::import(new ImportPesertaBpjs(), $data['attachment'], 'public');
                        //                        }
                    })
                    ->icon('heroicon-o-arrow-down-tray')
                    ->disabled(fn(): bool => cek_batas_input(setting('app.batas_tgl_input_bpjs')))
                    ->modalAlignment(Alignment::Center)
                    ->closeModalByClickingAway(false)
                    ->successRedirectUrl(route('filament.admin.resources.peserta-bpjs.index'))
                    ->modalWidth('lg')
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nomor_kartu')
                    ->label('Nomor Kartu')
                    ->searchable()
                    ->formatStateUsing(fn($state) => Str::mask($state, '*', 4, 5))
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('No. Induk Kependudukan (NIK)')
                    ->searchable()
                    ->formatStateUsing(fn($state) => Str::mask($state, '*', 2, 12))
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->wrap()
                    ->searchable(),

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
            'index' => ManagePesertaBpjs::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole(superadmin_admin_roles())) {
            return parent::getEloquentQuery();
        }

        return parent::getEloquentQuery();
        //            ->where('kelurahan', auth()->user()->instansi_id);
    }
}
