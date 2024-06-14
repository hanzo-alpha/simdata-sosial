<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('peserta_bpjs', static function (Blueprint $table): void {
            $table->id();
            $table->string('nomor_kartu');
            $table->string('nik');
            $table->string('nama_lengkap')->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_rt')->nullable();
            $table->string('no_rw')->nullable();
            $table->string('dusun')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->unsignedTinyInteger('bulan')->default(now()->month)->nullable();
            $table->unsignedInteger('tahun')->default(now()->year)->nullable();
            $table->timestamp('is_mutasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_bpjs');
    }
};
