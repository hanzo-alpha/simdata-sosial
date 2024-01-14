<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\JenisPekerjaan;
use Illuminate\Database\Eloquent\Factories\Factory;

final class JenisPekerjaanFactory extends Factory
{
    protected $model = JenisPekerjaan::class;

    public function definition(): array
    {
        return [
            'nama_pekerjaan' => $this->faker->word(),
        ];
    }
}
