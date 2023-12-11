<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usulan_pengaktifan_tmt', static function (Blueprint $table) {
            $table->id();
            $table->string('nokk_tmt', 20);
            $table->string('nik_tmt', 20);
            $table->string('nama_lengkap');
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->unsignedTinyInteger('jenis_kelamin')->default(1)->nullable();
            $table->unsignedTinyInteger('status_nikah')->nullable()->default(1);
            $table->text('alamat');
            $table->string('nort')->nullable();
            $table->string('norw')->nullable();
            $table->string('kodepos')->nullable();
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('dusun')->nullable();
            $table->boolean('status_aktif')->nullable();
            $table->string('status_usulan')->nullable();
            $table->string('status_bpjs')->nullable();
            $table->string('keterangan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usulan_pengaktifan_tmt');
    }
};
