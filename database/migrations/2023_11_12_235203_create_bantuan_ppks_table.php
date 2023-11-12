<?php

use App\Models\Anggaran;
use App\Models\JenisBantuan;
use App\Models\JenisPelayanan;
use App\Models\Keluarga;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bantuan_ppks', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Keluarga::class)->constrained('keluarga')->cascadeOnUpdate();
            $table->json('jenis_ppks')->nullable();
            $table->foreignIdFor(JenisPelayanan::class)->constrained('jenis_pelayanan')->cascadeOnUpdate();
            $table->integer('penghasilan_rata_rata')->nullable();
            $table->foreignIdFor(JenisBantuan::class)->constrained('jenis_bantuan')->cascadeOnUpdate();
            $table->unsignedtinyInteger('status_rumah_tinggal')->nullable();
            $table->string('status_kondisi_rumah')->nullable();
            $table->foreignIdFor(Anggaran::class)->constrained('anggaran')->cascadeOnUpdate();
            $table->tinyInteger('status_bantuan')->nullable();
            $table->timestamps();
        });
    }
};
