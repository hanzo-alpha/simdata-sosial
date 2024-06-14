<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('rekap_penerima_bpjs', function (Blueprint $table): void {
            $table->id();
            $table->string('provinsi', 2)->nullable();
            $table->string('kabupaten', 4)->nullable();
            $table->string('kecamatan', 7);
            $table->string('kelurahan', 20);
            $table->unsignedTinyInteger('bulan')->default(now()->month);
            $table->unsignedInteger('jumlah')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_penerima_bpjs');
    }
};
