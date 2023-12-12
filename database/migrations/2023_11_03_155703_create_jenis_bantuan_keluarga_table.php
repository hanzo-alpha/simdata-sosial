<?php

use App\Models\JenisBantuan;
use App\Models\Keluarga;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenis_bantuan_keluarga', static function (Blueprint $table) {
            $table->foreignIdFor(JenisBantuan::class)->constrained('jenis_bantuan')->cascadeOnUpdate();
            $table->foreignIdFor(Keluarga::class)->constrained('keluarga')->cascadeOnUpdate();
            $table->morphs('bantuanable');
        });
    }
};
