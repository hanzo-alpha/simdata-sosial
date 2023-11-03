<?php

namespace Database\Factories;

use App\Models\PendidikanTerakhir;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendidikanTerakhirFactory extends Factory
{
    protected $model = PendidikanTerakhir::class;

    public function definition(): array
    {
        return [
            'nama_pendidikan' => $this->faker->word(),
        ];
    }
}
