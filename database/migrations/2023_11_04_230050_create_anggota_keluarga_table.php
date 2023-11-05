<?php

use App\Models\Anggota;
use App\Models\Keluarga;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anggota_keluarga', static function (Blueprint $table) {
            $table->foreignIdFor(Anggota::class)->constrained('anggota')->cascadeOnUpdate();
            $table->foreignIdFor(Keluarga::class)->constrained('keluarga')->cascadeOnUpdate();
        });
    }
};
