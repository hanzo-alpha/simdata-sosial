<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bantuan_bpjs', static function (Blueprint $table) {
            $table->id();
            $table->morphs('familyable');
            $table->json('attachments')->nullable();
            $table->json('bukti_foto')->nullable();
            $table->string('status_bpjs', 20)->nullable();
            $table->timestamps();
        });
    }
};
