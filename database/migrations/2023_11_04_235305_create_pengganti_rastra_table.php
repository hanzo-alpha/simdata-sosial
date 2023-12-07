<?php

use App\Models\Keluarga;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengganti_rastra', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Keluarga::class)->constrained('keluarga')->cascadeOnUpdate();
            $table->string('nokk_pengganti', 20);
            $table->string('nik_pengganti', 20);
            $table->string('nama_pengganti');
            $table->text('alamat_pengganti');
            $table->string('alasan_dikeluarkan')->nullable();
            $table->timestamps();
        });
    }
};
