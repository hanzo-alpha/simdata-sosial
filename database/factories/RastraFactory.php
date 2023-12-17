<?php

namespace Database\Factories;

use App\Models\Rastra;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RastraFactory extends Factory
{
    protected $model = Rastra::class;

    public function definition(): array
    {
        return [
            'dtks_id' => $this->faker->word(),
            'nama_kpm' => $this->faker->word(),
            'nik_kpm' => $this->faker->word(),
            'nokk_kpm' => $this->faker->word(),
            'alamat_kpm' => $this->faker->word(),
            'kecamatan' => $this->faker->word(),
            'kelurahan' => $this->faker->word(),
            'foto_penyerahan' => $this->faker->words(),
            'foto_ktp_kk' => $this->faker->words(),
            'lokasi_map' => $this->faker->word(),
            'tgl_penyerahan' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
