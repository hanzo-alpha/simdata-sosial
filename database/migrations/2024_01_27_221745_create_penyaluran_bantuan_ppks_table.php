<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('penyaluran_bantuan_ppks', static function (Blueprint $table): void {
            $table->id();
            $table->bigInteger('bantuan_ppks_id');
            $table->string('no_kk');
            $table->string('nik');
            $table->dateTime('tgl_penyerahan');
            $table->json('foto_penyerahan')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('status_penyaluran')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyaluran_bantuan_ppks');
    }
};
