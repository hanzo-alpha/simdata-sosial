<?php

namespace Database\Factories;

use App\Models\PenerimaManfaat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PenerimaManfaatFactory extends Factory
{
    protected $model = PenerimaManfaat::class;

    public function definition(): array
    {
        return [
            'dtks_id' => $this->faker->word(),
            'nokk' => $this->faker->word(),
            'nik' => $this->faker->word(),
            'nama_lengkap' => $this->faker->word(),
            'tempat_lahir' => $this->faker->word(),
            'tgl_lahir' => Carbon::now(),
            'notelp' => $this->faker->word(),
            'nama_ibu_kandung' => $this->faker->word(),
            'jenis_kelamin' => $this->faker->randomNumber(),
            'status_kawin' => $this->faker->randomNumber(),
            'status_penerima' => $this->faker->randomNumber(),
            'status_verifikasi' => $this->faker->word(),
            'jenis_pekerjaan' => $this->faker->randomNumber(),
            'hubungan_keluarga' => $this->faker->randomNumber(),
            'pendidikan_terakhir' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
