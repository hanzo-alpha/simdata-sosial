<?php

namespace App\Forms\Components;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusKawinEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
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
            Section::make('Data Keluarga')
                ->schema([
                    TextInput::make('dtks_id')
                        ->maxLength(36)
                        ->hidden()
                        ->dehydrated()
                        ->columnSpanFull()
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
                        ->columnSpanFull()
                        ->maxLength(255),
                    TextInput::make('nama_ibu_kandung')
                        ->label('Nama Ibu Kandung')
                        ->required()
                        ->columnSpanFull()
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
                ])->columns(2),

            Section::make('Data Alamat')
                ->schema([
                    AlamatForm::make('alamat')
                ]),


            Group::make()->schema([
                Section::make('Data Pendukung')
                    ->schema([
                        BantuanForm::make('bantuan'),
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
                    ]),
                Section::make('Status')
                    ->schema([
                        Select::make('status_kawin')
                            ->options(StatusKawinEnum::class)
                            ->default(StatusKawinEnum::KAWIN)
                            ->preload(),

                        ToggleButton::make('status_family')
                            ->offColor('danger')
                            ->onColor('primary')
                            ->offLabel('Non Aktif')
                            ->onLabel('Aktif')
                            ->default(true),
                    ]),
                Section::make('Unggah')
                    ->schema([
                        ImageForm::make('image')
                    ]),
            ])->columns(1),
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
            $family = $record?->getRelationValue($this->getRelationship());

            $component->state($family ? $family->toArray() : [
                'dtks_id' => null,
                'nik' => null,
                'nokk' => null,
                'nama_lengkap' => null,
                'tempat_lahir' => null,
                'tgl_lahir' => null,
                'notelp' => null,
                'alamat_penerima' => null,
                'no_rt' => null,
                'no_rw' => null,
                'dusun' => null,
                'kodepos' => null,
                'kecamatan' => null,
                'kelurahan' => null,
                'latitude' => null,
                'longitude' => null,
                'nama_ibu_kandung' => null,
                'pendidikan_terakhir_id' => null,
                'hubungan_keluarga_id' => null,
                'jenis_pekerjaan_id' => null,
                'status_kawin' => null,
                'jenis_kelamin' => null,
                'status_keluarga' => null,
            ]);
        });

        $this->dehydrated(false);
    }
}
