<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('detail_bantuan_ppks', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('barang_id')->nullable();
            $table->string('nama_bantuan')->nullable();
            $table->unsignedInteger('jumlah_bantuan')->nullable();
            $table->string('jenis_anggaran')->nullable();
            $table->unsignedInteger('tahun_anggaran')->default(now()->year)->nullable();
            $table->json('bansos_diterima')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_bantuan_ppks');
    }
};
