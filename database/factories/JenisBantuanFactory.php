<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\JenisBantuan;
use Illuminate\Database\Eloquent\Factories\Factory;

final class JenisBantuanFactory extends Factory
{
    protected $model = JenisBantuan::class;

    public function definition(): array
    {
        return [
            'nama_bantuan' => $this->faker->word(),
            'alias' => $this->faker->word(),
            'warna' => $this->faker->word(),
            'deskripsi' => $this->faker->word(),
        ];
    }
}
