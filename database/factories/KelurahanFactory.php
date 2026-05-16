<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Kelurahan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kelurahan>
 */
class KelurahanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->numerify('##########'),
            'kecamatan_code' => \App\Models\Kecamatan::factory(),
            'name' => $this->faker->streetName(),
        ];
    }
}
