<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('provinsi', static function (Blueprint $table) {
            $table->char('code', 2)->primary();
            $table->string('name', 255);
        });

        Schema::create('kabupaten', static function (Blueprint $table) {
            $table->char('code', 4)->primary();
            $table->char('provinsi_code', 2);
            $table->string('name', 255);
            $table->foreign('provinsi_code')
                ->references('code')
                ->on('provinsi')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });

        Schema::create('kecamatan', static function (Blueprint $table) {
            $table->char('code', 7)->primary();
            $table->char('kabupaten_code', 4);
            $table->string('name', 255);
            $table->foreign('kabupaten_code')
                ->references('code')
                ->on('kabupaten')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });

        Schema::create('kelurahan', static function (Blueprint $table) {
            $table->char('code', 10)->primary();
            $table->char('kecamatan_code', 7);
            $table->string('name', 255);
            $table->foreign('kecamatan_code')
                ->references('code')
                ->on('kecamatan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });

        Schema::create('pulau', static function (Blueprint $table) {
            $table->id();
            $table->char('code', 5);
            $table->char('provinsi_code', 2);
            $table->char('kabupaten_code', 4);
            $table->string('name', 255);
            $table->foreign('provinsi_code')
                ->references('code')
                ->on('provinsi')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreign('kabupaten_code')
                ->references('code')
                ->on('kabupaten')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }
};
