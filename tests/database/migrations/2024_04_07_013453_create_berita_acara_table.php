<?php

use App\Models\BantuanRastra;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('berita_acara', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('nomor_ba');
            $table->string('judul_ba');
            $table->date('tgl_ba')->nullable()->default(today());
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->foreignId('barang_id');
            $table->foreignId('penandatangan_id');
            $table->string('keterangan')->nullable();
            $table->json('bantuan_rastra_ids')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_acara');
    }
};
