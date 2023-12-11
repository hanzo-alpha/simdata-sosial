<?php

namespace Database\Factories;

use App\Models\SubJenisDisabilitas;
use Illuminate\Database\Eloquent\Factories\Factory;

class KriteriaPelayananFactory extends Factory
{
    protected $model = SubJenisDisabilitas::class;

    public function definition(): array
    {
        return [
            'jenis_pelayanan_id' => $this->faker->randomNumber(),
            'nama_kriteria' => $this->faker->word(),
            'deskripsi' => $this->faker->word(),
        ];
    }
}
