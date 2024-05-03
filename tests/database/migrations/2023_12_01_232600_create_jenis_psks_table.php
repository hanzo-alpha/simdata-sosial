<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('jenis_psks', static function (Blueprint $table): void {
            $table->id();
            $table->string('nama_psks');
            $table->string('alias')->nullable();
            $table->string('deskripsi')->nullable();
        });
    }
};
