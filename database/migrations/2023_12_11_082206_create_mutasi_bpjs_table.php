<?php

declare(strict_types=1);

use App\Enums\AlasanEnum;
use App\Enums\StatusAktif;
use App\Enums\TipeMutasiEnum;
use App\Models\PesertaBpjs;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('mutasi_bpjs', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(PesertaBpjs::class)
                ->constrained('peserta_bpjs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('bantuan_bpjs_id')->nullable();
            $table->string('nomor_kartu')->index()->nullable();
            $table->string('nik')->index()->nullable();
            $table->string('nama_lengkap')->index()->nullable();
            $table->string('alasan_mutasi')->default(AlasanEnum::MAMPU)->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status_mutasi')->default(StatusAktif::NONAKTIF)->nullable();
            $table->string('tipe_mutasi')->default(TipeMutasiEnum::PESERTA_BPJS)->nullable();
            $table->string('model_name')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_bpjs');
    }
};
