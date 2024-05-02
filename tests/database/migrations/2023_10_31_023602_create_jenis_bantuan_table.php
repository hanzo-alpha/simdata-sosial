<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('jenis_bantuan', static function (Blueprint $table): void {
            $table->id();
            $table->string('nama_bantuan');
            $table->string('alias')->nullable();
            $table->string('warna')->nullable();
            $table->string('deskripsi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_bantuan');
    }
};
