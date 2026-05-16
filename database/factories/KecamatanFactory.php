<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Kecamatan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kecamatan>
 */
class KecamatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->numerify('#######'),
            'kabupaten_code' => \App\Models\Kabupaten::factory(),
            'name' => $this->faker->city(),
        ];
    }
}
