<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenis_pelayanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ppks');
            $table->string('alias')->nullable();
            $table->string('deskripsi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_pelayanan');
    }
};
