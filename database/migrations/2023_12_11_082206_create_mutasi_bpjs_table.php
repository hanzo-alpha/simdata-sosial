<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mutasi_bpjs', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk');
            $table->string('nik');
            $table->string('nama_lengkap');
            $table->unsignedTinyInteger('jenis_kelamin')->nullable();
            $table->string('nomor_kartu')->nullable();
            $table->string('alasan_mutasi')->nullable();
            $table->text('alamat')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status_mutasi')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_bpjs');
    }
};
