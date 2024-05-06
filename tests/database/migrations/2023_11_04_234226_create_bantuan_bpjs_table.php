<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bantuan_bpjs', static function (Blueprint $table): void {
            $table->id();
            $table->uuid('dtks_id')->nullable()->default(Str::uuid()->toString());
            $table->string('nomor_kartu', 20)->nullable();
            $table->string('nokk_tmt', 20);
            $table->string('nik_tmt', 20);
            $table->string('nama_lengkap');
            $table->string('tempat_lahir', 50);
            $table->dateTime('tgl_lahir');
            $table->string('tgl_lahir_tmp')->nullable();
            $table->tinyInteger('jenis_kelamin')
                ->nullable()
                ->default(1);
            $table->tinyInteger('status_nikah')
                ->nullable()
                ->default(1);
            $table->text('alamat');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('dusun')->nullable();
            $table->char('nort', 5)->nullable();
            $table->char('norw', 5)->nullable();
            $table->char('kodepos', 10)->nullable();
            $table->unsignedBigInteger('jenis_bantuan_id')->nullable();
            $table->unsignedTinyInteger('status_aktif')
                ->nullable()
                ->default(0);
            $table->string('status_usulan', 20)->nullable();
            $table->string('status_bpjs', 20)->nullable();
            $table->string('bulan', 10)->nullable()->default(today()->monthName);
            $table->unsignedInteger('tahun')->nullable()->default(today()->year);
            $table->text('keterangan')->nullable();
            $table->json('foto_ktp')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
};
