<?php

declare(strict_types=1);

use App\Enums\AlasanEnum;
use App\Enums\StatusMutasi;
use App\Enums\TipeMutasiEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('mutasi_bpjs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('peserta_bpjs_id')->index()->nullable();
            $table->foreignId('bantuan_bpjs_id')->nullable();
            $table->string('alasan_mutasi')->default(AlasanEnum::MAMPU)->nullable();
            $table->char('periode_bulan', 2)->default(now()->month)->nullable();
            $table->year('periode_tahun')->default(now()->year)->nullable();
            $table->string('status_mutasi')->default(StatusMutasi::MUTASI)->nullable();
            $table->string('tipe_mutasi')->default(TipeMutasiEnum::PESERTA_BPJS)->nullable();
            $table->string('model_name')->nullable();
            $table->string('no_surat_kematian', 16)->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('media_id')->index()->nullable();
            $table->string('lampiran')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_bpjs');
    }
};
