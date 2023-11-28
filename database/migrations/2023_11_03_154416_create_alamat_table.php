<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alamat', function (Blueprint $table) {
            $table->id();
            $table->text('nama_alamat');
            $table->string('no_rt')->nullable();
            $table->string('no_rw')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('dusun')->nullable();
            $table->string('kodepos')->nullable();
            $table->string('location')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->string('alamat_lengkap')->virtualAs("CONCAT(nama_alamat, ', ',
             'RT. ' ,no_rt, ', ', 'RW. ', no_rw, ', ', dusun, ' ', kodepos)");

            $table->timestamps();
        });
    }
};
