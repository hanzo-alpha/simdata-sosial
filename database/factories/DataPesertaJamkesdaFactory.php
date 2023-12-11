<?php

namespace Database\Factories;

use App\Models\DataPesertaJamkesda;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DataPesertaJamkesdaFactory extends Factory
{
    protected $model = DataPesertaJamkesda::class;

    public function definition(): array
    {
        return [
            'nomor_kartu' => $this->faker->word(),
            'nik' => $this->faker->word(),
            'nama_lengkap' => $this->faker->word(),
            'alamat' => $this->faker->word(),
            'no_rt' => $this->faker->word(),
            'no_rw' => $this->faker->word(),
            'dusun' => $this->faker->word(),
            'kabupaten' => $this->faker->word(),
            'kecamatan' => $this->faker->word(),
            'kelurahan' => $this->faker->word(),
            'bulan' => $this->faker->word(),
            'tahun' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
