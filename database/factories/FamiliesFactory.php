<?php

namespace Database\Factories;

use App\Models\Families;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FamiliesFactory extends Factory
{
    protected $model = Families::class;

    public function definition(): array
    {
        return [
            'dtks_id' => $this->faker->words(),
            'nokk' => $this->faker->word(),
            'nik' => $this->faker->word(),
            'nama_lengkap' => $this->faker->word(),
            'notelp' => $this->faker->word(),
            'tempat_lahir' => $this->faker->word(),
            'tgl_lahir' => Carbon::now(),
            'status_family' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
