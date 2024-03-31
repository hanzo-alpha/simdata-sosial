<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('penandatangan', static function (Blueprint $table): void {
            $table->id();
            $table->string('kode_instansi');
            $table->string('nama_penandatangan');
            $table->string('nip');
            $table->string('jabatan');
            $table->string('kode_kecamatan')->nullable();
            $table->tinyInteger('status_penandatangan')->nullable()->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penandatangan');
    }
};
