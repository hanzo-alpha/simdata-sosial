<?php

namespace App\Forms\Components;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusKawinEnum;
use App\Enums\StatusVerifikasiEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Wallo\FilamentSelectify\Components\ToggleButton;

class FamilyForm extends Field
{
    public ?string $relationship = null;

    protected string $view = 'filament-forms::components.group';

    public function saveRelationships(): void
    {
        $state = $this->getState();
        $record = $this->getRecord();
        $relationship = $record?->{$this->getRelationship()}();

        if ($relationship === null) {
            return;
        }

        if ($address = $relationship->first()) {
            $address->update($state);
        } else {
            $relationship->updateOrCreate($state);
        }

        $record?->touch();
    }

    public function getRelationship(): string
    {
        return $this->evaluate($this->relationship) ?? $this->getName();
    }

    public function getChildComponents(): array
    {
        return [
            Grid::make()
                ->schema([
                    TextInput::make('nokk')
                        ->label('No. Kartu Keluarga')
                        ->autofocus()
                        ->required()
                        ->unique()
                        ->maxLength(20),
                    TextInput::make('nik')
                        ->label('Nomor Induk Kependudukan (NIK)')
                        ->required()
                        ->unique()
                        ->maxLength(20),
                    TextInput::make('nama_lengkap')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('notelp')
                        ->label('No. Telp/HP')
                        ->tel()
                        ->required()
                        ->maxLength(18),
                    TextInput::make('tempat_lahir')
                        ->label('Tempat Lahir')
                        ->required()
                        ->maxLength(50),
                    DatePicker::make('tgl_lahir')
                        ->label('Tanggal Lahir')
                        ->displayFormat('d/m/Y')
                        ->required(),
                    Grid::make(2)->schema([
                        TextInput::make('latitude')
                            ->live(true)
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('location', [
                                    'lat' => floatVal($state),
                                    'lng' => (float) $get('longitude'),
                                ]);
                            })
                            ->lazy(), // important to use lazy, to avoid updates as you type
                        TextInput::make('longitude')
                            ->live(true)
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('location', [
                                    'lat' => (float) $get('latitude'),
                                    'lng' => floatVal($state),
                                ]);
                            })
                            ->lazy(),
                    ]),
                ]),
            Grid::make(2)
                ->schema([
                    Select::make('jenis_bantuan_id')
                        ->required()
                        ->searchable()
                        ->relationship('jenis_bantuan', 'nama_bantuan')
                        ->preload()
                        ->optionsLimit(20),
                    Select::make('pendidikan_terakhir_id')
                        ->required()
                        ->searchable()
                        ->relationship('pendidikan_terakhir', 'nama_pendidikan')
                        ->preload()
                        ->optionsLimit(20),
                    Select::make('hubungan_keluarga_id')
                        ->required()
                        ->searchable()
                        ->relationship('hubungan_keluarga', 'nama_hubungan')
                        ->preload()
                        ->optionsLimit(20),
                    Select::make('jenis_pekerjaan_id')
                        ->required()
                        ->searchable()
                        ->relationship('jenis_pekerjaan', 'nama_pekerjaan')
                        ->preload()
                        ->optionsLimit(20),
                    TextInput::make('nama_ibu_kandung')
                        ->required()
                        ->maxLength(255),
                    Select::make('status_kawin')
                        ->searchable()
                        ->options(StatusKawinEnum::class),
                    Select::make('jenis_kelamin')
                        ->options(JenisKelaminEnum::class),
                    Select::make('status_verifikasi')
                        ->options(StatusVerifikasiEnum::class),
                    ToggleButton::make('status_keluarga')
                        ->offColor('danger')
                        ->onColor('primary')
                        ->offLabel('Non Aktif')
                        ->onLabel('Aktif')
                        ->default(true),
                ]),
        ];
    }

    public function relationship(string|callable $relationship): static
    {
        $this->relationship = $relationship;

        return $this;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (FamilyForm $component, ?Model $record) {
            $keluarga = $record?->getRelationValue($this->getRelationship());

            $component->state($keluarga ? $keluarga->toArray() : [
                'dtks_id' => null,
                'nokk' => null,
                'nik' => null,
                'nama_lengkap' => null,
                'tempat_lahir' => null,
                'tgl_lahir' => null,
                'notelp' => null,
                'alamat_id' => null,
                'nama_ibu_kandung' => null,
                'jenis_bantuan_id' => null,
                'pendidikan_terakhir_id' => null,
                'hubungan_keluarga_id' => null,
                'jenis_pekerjaan_id' => null,
                'status_kawin' => null,
                'jenis_kelamin' => null,
                'status_keluarga' => null,
                'status_verifikasi' => null,
                'unggah_foto' => null,
                'unggah_dokumen' => null,
            ]);
        });

        $this->dehydrated(false);
    }
}
