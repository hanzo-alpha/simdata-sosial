<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('> Mulai wilayah seeder...');

        $startTime = microtime(true);

        Schema::disableForeignKeyConstraints();

        $this->call(ProvinsiTableSeeder::class);
        $this->call(KabupatenTableSeeder::class);
        $this->call(KecamatanTableSeeder::class);
        $this->call(KelurahanTableSeeder::class);
        $this->call(PulauTableSeeder::class);

        Schema::enableForeignKeyConstraints();

        $endTime = round(microtime(true) - $startTime, 2);

        $this->command->info("> ✔ OK: Took {$endTime} seconds.");
    }
}
