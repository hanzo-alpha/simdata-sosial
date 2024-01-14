<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\HubunganKeluarga;
use Illuminate\Database\Eloquent\Factories\Factory;

final class HubunganKeluargaFactory extends Factory
{
    protected $model = HubunganKeluarga::class;

    public function definition(): array
    {
        return [
            'nama_hubungan' => $this->faker->word(),
        ];
    }
}
