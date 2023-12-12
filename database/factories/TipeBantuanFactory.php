<?php

namespace Database\Factories;

use App\Models\Bantuan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TipeBantuanFactory extends Factory
{
    protected $model = Bantuan::class;

    public function definition(): array
    {
        return [
            'nama_tipe' => $this->faker->word(),
            'alias' => $this->faker->word(),
            'deskripsi' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
