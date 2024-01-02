<?php

use App\Models\HubunganKeluarga;
use App\Models\JenisBantuan;
use App\Models\JenisPekerjaan;
use App\Models\JenisPelayanan;
use App\Models\JenisPpks;
use App\Models\PendidikanTerakhir;
use App\Models\TipePpks;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bantuan_ppks', static function (Blueprint $table) {
            $table->id();
            $table->uuid('dtks_id')->nullable()->default(Str::uuid()->toString());
            $table->string('nokk', 20);
            $table->string('nik', 20);
            $table->string('nama_lengkap');
            $table->string('tempat_lahir', 50);
            $table->dateTime('tgl_lahir');
            $table->string('notelp', 18);
            $table->string('nama_ibu_kandung');
            $table->foreignIdFor(JenisBantuan::class)
                ->nullable()
                ->default(4)
                ->constrained('jenis_bantuan')
                ->cascadeOnUpdate();
            $table->foreignIdFor(PendidikanTerakhir::class)->constrained('pendidikan_terakhir')->cascadeOnUpdate();
            $table->foreignIdFor(HubunganKeluarga::class)->constrained('hubungan_keluarga')->cascadeOnUpdate();
            $table->foreignIdFor(JenisPekerjaan::class)->constrained('jenis_pekerjaan')->cascadeOnUpdate();
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
            $table->foreignIdFor(TipePpks::class)->constrained('tipe_ppks')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->json('kriteria_ppks')->nullable();
            $table->integer('penghasilan_rata_rata')->nullable();
            $table->json('bantuan_yang_pernah_diterima')->nullable();
            $table->unsignedInteger('tahun_anggaran')->nullable();
            $table->string('jenis_anggaran', 10)->nullable();
            $table->unsignedInteger('jumlah_bantuan')->nullable();
            $table->unsignedtinyInteger('status_rumah_tinggal')->nullable();
            $table->string('status_kondisi_rumah')->nullable();
            $table->tinyInteger('status_bantuan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
};
