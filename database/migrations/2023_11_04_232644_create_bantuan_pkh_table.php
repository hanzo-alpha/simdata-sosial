<?php

use App\Models\Keluarga;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bantuan_pkh', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Keluarga::class)->constrained('keluarga')->cascadeOnUpdate();
            $table->string('kode_wilayah')->nullable();
            $table->string('tahap')->nullable();
            $table->bigInteger('jenis_bantuan_id')->nullable();
            $table->uuid('dtks_id')->nullable();
            $table->string('bank')->nullable();
            $table->string('dir')->nullable();
            $table->string('gelombang')->nullable();
            $table->unsignedInteger('nominal')->nullable()->default(0);
            $table->tinyInteger('status_pkh')->nullable();
            $table->timestamps();
        });
    }
};
