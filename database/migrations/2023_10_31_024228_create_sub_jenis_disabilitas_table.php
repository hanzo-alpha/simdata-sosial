<?php

use App\Models\JenisDisabilitas;
use App\Models\JenisPelayanan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sub_jenis_disabilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JenisDisabilitas::class)
                ->constrained('jenis_disabilitas')
                ->cascadeOnUpdate();
            $table->string('nama_sub_jenis');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_jenis_disabilitas');
    }
};
