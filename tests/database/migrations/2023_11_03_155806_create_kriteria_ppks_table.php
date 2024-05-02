<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('kriteria_ppks', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('tipe_ppks_id')->nullable();
            $table->string('nama_kriteria');
            $table->string('alias')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }
};
