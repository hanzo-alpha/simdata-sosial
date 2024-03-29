<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\JenisPelayanan;
use Illuminate\Database\Eloquent\Factories\Factory;

final class JenisPelayananFactory extends Factory
{
    protected $model = JenisPelayanan::class;

    public function definition(): array
    {
        return [
            'nama_ppks' => $this->faker->word(),
            'alias' => $this->faker->word(),
            'deskripsi' => $this->faker->word(),
        ];
    }
}
