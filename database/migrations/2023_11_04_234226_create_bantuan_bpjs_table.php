<?php

use App\Models\Keluarga;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bantuan_bpjs', static function (Blueprint $table) {
            $table->id();
            $table->uuid('dkts_id')->nullable();
            $table->foreignIdFor(Keluarga::class)->constrained('keluarga')->cascadeOnUpdate();
            $table->json('attachments')->nullable();
            $table->json('bukti_foto')->nullable();
            $table->json('dokumen')->nullable();
            $table->tinyInteger('status_bpjs')->nullable();
            $table->timestamps();
        });
    }
};
