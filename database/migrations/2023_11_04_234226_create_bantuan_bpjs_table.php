<?php

use App\Models\HubunganKeluarga;
use App\Models\JenisBantuan;
use App\Models\JenisPekerjaan;
use App\Models\PendidikanTerakhir;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bantuan_bpjs', static function (Blueprint $table) {
            $table->id();
            $table->uuid('dtks_id')->nullable()->default(Str::uuid()->toString());
            $table->string('nokk', 20);
            $table->string('nik', 20);
            $table->string('nama_lengkap');
            $table->string('tempat_lahir', 50);
            $table->dateTime('tgl_lahir');
            $table->string('notelp', 18);
            $table->string('nama_ibu_kandung');
            $table->string('nomor_kartu', 20)->nullable();
            $table->foreignIdFor(JenisBantuan::class)
                ->nullable()
                ->constrained('jenis_bantuan')
                ->cascadeOnUpdate();
            $table->foreignIdFor(PendidikanTerakhir::class)
                ->nullable()
                ->constrained('pendidikan_terakhir')->cascadeOnUpdate();
            $table->foreignIdFor(HubunganKeluarga::class)
                ->nullable()
                ->constrained('hubungan_keluarga')->cascadeOnUpdate();
            $table->foreignIdFor(JenisPekerjaan::class)
                ->nullable()
                ->constrained('jenis_pekerjaan')->cascadeOnUpdate();
            $table->tinyInteger('status_kawin')
                ->nullable()
                ->default(1);
            $table->tinyInteger('jenis_kelamin')
                ->nullable()
                ->default(1);
            $table->string('status_verifikasi')
                ->nullable()
                ->default(0);
            $table->tinyInteger('status_aktif')
                ->nullable()
                ->default(0);
            $table->json('bukti_foto')->nullable();
            $table->string('status_bpjs', 20)->nullable();
            $table->json('mutasi')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
};
