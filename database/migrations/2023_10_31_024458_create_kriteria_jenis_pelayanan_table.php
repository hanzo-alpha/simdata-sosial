<?php

use App\Models\JenisPelayanan;
use App\Models\KriteriaPelayanan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kriteria_jenis_pelayanan', static function (Blueprint $table) {
            $table->foreignIdFor(KriteriaPelayanan::class)
                ->constrained('kriteria_pelayanan')
                ->cascadeOnUpdate();
            $table->foreignIdFor(JenisPelayanan::class)
                ->constrained('jenis_pelayanan')
                ->cascadeOnUpdate();
        });
    }
};
