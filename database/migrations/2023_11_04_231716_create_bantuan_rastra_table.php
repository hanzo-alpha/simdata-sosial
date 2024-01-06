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
        Schema::create('bantuan_rastra', static function (Blueprint $table) {
            $table->id();
            $table->uuid('dtks_id')->nullable()->default(Str::uuid()->toString());
            $table->string('nokk', 20);
            $table->string('nik', 20);
            $table->string('nama_lengkap');
            $table->string('tempat_lahir', 50)->nullable();
            $table->dateTime('tgl_lahir')->nullable();
            $table->string('notelp', 18)->nullable();
            $table->string('nama_ibu_kandung')->nullable();
            $table->foreignIdFor(JenisBantuan::class)
                ->nullable()
                ->constrained('jenis_bantuan')
                ->cascadeOnUpdate();
            $table->foreignIdFor(PendidikanTerakhir::class)
                ->nullable()
                ->constrained('pendidikan_terakhir');
            $table->foreignIdFor(HubunganKeluarga::class)
                ->nullable()
                ->constrained('hubungan_keluarga');
            $table->foreignIdFor(JenisPekerjaan::class)
                ->nullable()
                ->constrained('jenis_pekerjaan');
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
            $table->json('foto_pegang_ktp')->nullable();
            $table->tinyInteger('status_rastra')->nullable();
            $table->json('pengganti_rastra')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
