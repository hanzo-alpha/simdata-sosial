<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bnba_rastra', static function (Blueprint $table): void {
            $table->id();
            $table->string('dtks_id', 40)->nullable();
            $table->string('nama');
            $table->string('no_kk', 20);
            $table->string('nik', 20);
            $table->string('alamat');
            $table->string('desa_kel', 50);
            $table->string('kecamatan', 50);
            $table->string('status_dtks', 30);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bnba_rastra');
    }
};
