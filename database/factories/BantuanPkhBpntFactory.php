<?php

namespace Database\Factories;

use App\Models\BantuanPkhBpnt;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BantuanPkhBpntFactory extends Factory
{
    protected $model = BantuanPkhBpnt::class;

    public function definition(): array
    {
        return [
            'dtks_id' => $this->faker->uuid(),
            'nokk' => '7312' . date('dmy') . \Str::random(4),
            'nik_ktp' => '7312' . date('dmy') . \Str::random(4),
            'nama_penerima' => $this->faker->name(),
            'kode_wilayah' => $this->faker->word(),
            'tahap' => $this->faker->word(),
            'bansos' => $this->faker->word(),
            'bank' => $this->faker->word(),
            'provinsi' => $this->faker->word(),
            'kabupaten' => $this->faker->word(),
            'kecamatan' => $this->faker->word(),
            'kelurahan' => $this->faker->word(),
            'alamat' => $this->faker->word(),
            'no_rt' => $this->faker->word(),
            'no_rw' => $this->faker->word(),
            'dusun' => $this->faker->word(),
            'dir' => 'Dir' . ' ' . $this->faker->word(),
            'gelombang' => 'GEL' . \Str::random(1),
            'status_pkhbpnt' => \Str::random(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
