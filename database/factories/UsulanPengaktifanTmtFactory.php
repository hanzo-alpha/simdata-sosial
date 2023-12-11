<?php

namespace Database\Factories;

use App\Models\UsulanPengaktifanTmt;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UsulanPengaktifanTmtFactory extends Factory
{
    protected $model = UsulanPengaktifanTmt::class;

    public function definition(): array
    {
        return [
            'nokk_tmt' => $this->faker->word(),
            'nik_tmt' => $this->faker->word(),
            'nama_lengkap' => $this->faker->word(),
            'tempat_lahir' => $this->faker->word(),
            'tgl_lahir' => Carbon::now(),
            'jenis_kelamin' => $this->faker->word(),
            'status_nikah' => $this->faker->word(),
            'alamat' => $this->faker->word(),
            'nort' => $this->faker->word(),
            'norw' => $this->faker->word(),
            'kodepos' => $this->faker->word(),
            'kecamatan' => $this->faker->word(),
            'kelurahan' => $this->faker->word(),
            'dusun' => $this->faker->word(),
            'status_aktif' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
