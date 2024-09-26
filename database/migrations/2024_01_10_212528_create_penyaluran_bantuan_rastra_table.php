<?php

declare(strict_types=1);

use App\Enums\StatusPenyaluran;
use App\Models\BantuanRastra;
use App\Models\Penandatangan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('penyaluran_bantuan_rastra', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(BantuanRastra::class)
                ->nullable()
                ->constrained('bantuan_rastra')
                ->noActionOnDelete()
                ->noActionOnUpdate();
            $table->string('no_kk')->nullable();
            $table->string('nik_kpm')->nullable();
            $table->dateTime('tgl_penyerahan')->nullable();
            $table->json('foto_penyerahan');
            $table->unsignedBigInteger('media_id')->nullable();
            $table->longText('lokasi');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('status_penyaluran')->nullable()->default(StatusPenyaluran::BELUM_TERSALURKAN);
            $table->foreignIdFor(Penandatangan::class)->nullable()->index();
            $table->string('keterangan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyaluran_bantuan_rastra');
    }
};
