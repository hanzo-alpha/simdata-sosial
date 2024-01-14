<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PendidikanTerakhir;
use Illuminate\Database\Eloquent\Factories\Factory;

final class PendidikanTerakhirFactory extends Factory
{
    protected $model = PendidikanTerakhir::class;

    public function definition(): array
    {
        return [
            'nama_pendidikan' => $this->faker->word(),
        ];
    }
}
