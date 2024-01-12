<?php

use App\Enums\StatusPenyaluran;
use App\Models\BantuanRastra;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penyaluran_bantuan_rastra', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BantuanRastra::class)
                ->nullable()
                ->constrained('bantuan_rastra')
                ->noActionOnDelete()
                ->noActionOnUpdate();
            $table->dateTime('tgl_penyerahan')->nullable();
            $table->json('foto_penyerahan');
            $table->json('foto_ktp_kk');
            $table->longText('lokasi');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('status_penyaluran')->nullable()->default(StatusPenyaluran::BELUM_TERSALURKAN);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyaluran_bantuan_rastra');
    }
};
