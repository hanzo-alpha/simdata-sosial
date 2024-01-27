<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bnba_rastra', static function (Blueprint $table): void {
            $table->id();
            $table->string('dtks_id')->nullable();
            $table->string('nama');
            $table->string('no_kk');
            $table->string('nik');
            $table->string('alamat');
            $table->string('desa_kel');
            $table->string('kecamatan');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bnba_rastra');
    }
};
