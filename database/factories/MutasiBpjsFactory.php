<?php

namespace Database\Factories;

use App\Models\MutasiBpjs;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MutasiBpjsFactory extends Factory
{
    protected $model = MutasiBpjs::class;

    public function definition(): array
    {
        return [
            'nokk_tmt' => $this->faker->word(),
            'nik_tmt' => $this->faker->word(),
            'nama_lengkap' => $this->faker->word(),
            'jenis_kelamin' => $this->faker->randomNumber(),
            'nomor_kartu' => $this->faker->word(),
            'alasan_mutasi' => $this->faker->word(),
            'alamat' => $this->faker->word(),
            'keterangan' => $this->faker->word(),
            'status_mutasi' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
