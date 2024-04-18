<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('barang', static function (Blueprint $table): void {
            $table->id();
            $table->string('kode_barang')->nullable();
            $table->string('nama_barang');
            $table->unsignedInteger('kuantitas')->nullable()->default(0);
            $table->string('satuan')->nullable();
            $table->unsignedDouble('harga_satuan')->nullable()->default(0);
            $table->unsignedDouble('total_harga')->nullable()->default(0);
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
