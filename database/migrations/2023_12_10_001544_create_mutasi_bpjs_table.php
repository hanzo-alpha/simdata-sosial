<?php
declare(strict_types=1);

use App\Enums\AlasanEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mutasi_bantuan_bpjs', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bantuan_bpjs_id')->nullable();
            $table->unsignedBigInteger('keluarga_yang_dimutasi_id')->nullable();
            $table->string('alasan_mutasi')->nullable()->default(AlasanEnum::PINDAH);
            $table->timestamps();
        });
    }
};
