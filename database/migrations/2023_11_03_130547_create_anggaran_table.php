<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anggaran', static function (Blueprint $table) {
            $table->id();
            $table->string('nama_anggaran');
            $table->integer('jumlah_anggaran')->nullable();
            $table->year('tahun_anggaran')->nullable();
        });
    }
};
