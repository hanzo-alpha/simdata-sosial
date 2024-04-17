<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bantuan_bpnt', static function (Blueprint $table): void {
            $table->id();
            $table->string('no_nik');
            $table->string('nama_penerima');
            $table->char('provinsi', 2)->nullable();
            $table->char('kabupaten', 5)->nullable();
            $table->char('kecamatan', 7)->nullable();
            $table->char('kelurahan', 10)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bantuan_bpnt');
    }
};
