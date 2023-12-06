<?php

use App\Models\JenisPelayanan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kriteria_pelayanan', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JenisPelayanan::class)
                ->constrained('jenis_pelayanan')
                ->cascadeOnUpdate();
            $table->string('nama_kriteria');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kriteria_pelayanan');
    }
};
