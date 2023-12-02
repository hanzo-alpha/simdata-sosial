<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bantuan', static function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alias')->nullable();
            $table->string('warna')->nullable();
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('bantuanables', static function (Blueprint $table) {
            $table->foreignId('bantuan_id');
            $table->morphs('bantuanable');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bantuan');
        Schema::dropIfExists('bantuanables');
    }
};
