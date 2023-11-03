<?php

namespace Database\Factories;

use App\Models\HubunganKeluarga;
use Illuminate\Database\Eloquent\Factories\Factory;

class HubunganKeluargaFactory extends Factory
{
    protected $model = HubunganKeluarga::class;

    public function definition(): array
    {
        return [
            'nama_hubungan' => $this->faker->word(),
        ];
    }
}
