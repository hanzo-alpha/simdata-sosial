<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BantuanRastra;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BantuanRastra>
 */
class BantuanRastraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_lengkap' => $this->faker->name(),
            'nik' => $this->faker->unique()->numerify('################'),
            'nokk' => $this->faker->numerify('################'),
            'alamat' => $this->faker->address(),
            'kecamatan' => \App\Models\Kecamatan::factory()->create()->code,
            'kelurahan' => \App\Models\Kelurahan::factory()->create()->code,
            'status_rastra' => \App\Enums\StatusRastra::BARU,
            'status_aktif' => \App\Enums\StatusAktif::AKTIF,
            'status_verifikasi' => \App\Enums\StatusVerifikasiEnum::VERIFIED,
            'status_dtks' => \App\Enums\StatusDtksEnum::DTKS,
            'tahun' => now()->year,
        ];
    }
}
