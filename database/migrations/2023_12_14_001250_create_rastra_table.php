<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rastra', static function (Blueprint $table) {
            $table->id();
            $table->string('dtks_id')->default(Str::uuid()->toString())->nullable();
            $table->string('nama_kpm');
            $table->string('nik_kpm');
            $table->string('nokk_kpm')->nullable();
            $table->string('nama_ibu_kandung')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->unsignedBigInteger('hubungan_keluarga_id')->nullable();
            $table->unsignedTinyInteger('status_kawin')->nullable();
            $table->unsignedTinyInteger('jenis_kelamin')->nullable();
            $table->text('alamat_kpm')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->unsignedBigInteger('jenis_bantuan_id')->nullable();
            $table->json('foto_penyerahan')->nullable();
            $table->json('foto_ktp_kk')->nullable();
            $table->string('lokasi_map')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('tgl_penyerahan')->default(today())->nullable();
            $table->string('status_penyerahan', 25)->nullable();
            $table->boolean('status_aktif')->nullable();
            $table->string('status_verifikasi', 25)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rastra');
    }
};
