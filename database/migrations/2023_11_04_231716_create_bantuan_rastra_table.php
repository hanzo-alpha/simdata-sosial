<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bantuan_rastra', static function (Blueprint $table) {
            $table->id();
            $table->morphs('familyable');
            $table->string('nik_penerima')->nullable();
            $table->json('attachments')->nullable();
            $table->json('bukti_foto')->nullable();
            $table->json('location')->nullable();
            $table->tinyInteger('status_rastra')->nullable();
            $table->timestamps();
        });
    }
};
