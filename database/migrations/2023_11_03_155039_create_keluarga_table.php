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
        Schema::create('keluarga', static function (Blueprint $table) {
            $table->id();
            $table->morphs('alamatable');
            $table->uuid('dtks_id')->nullable()->default(Str::uuid()->toString());
            $table->string('nokk', 20);
            $table->string('nik', 20);
            $table->string('nama_lengkap');
            $table->string('tempat_lahir', 50);
            $table->dateTime('tgl_lahir');
            $table->string('notelp', 18);
            $table->string('alamat')->default('Jalan Salotungo No. 10');
            $table->string('nama_ibu_kandung');
            $table->foreignIdFor(JenisBantuan::class)->constrained('jenis_bantuan')->cascadeOnUpdate();
            $table->foreignIdFor(PendidikanTerakhir::class)->constrained('pendidikan_terakhir')->cascadeOnUpdate();
            $table->foreignIdFor(HubunganKeluarga::class)->constrained('hubungan_keluarga')->cascadeOnUpdate();
            $table->foreignIdFor(JenisPekerjaan::class)->constrained('jenis_pekerjaan')->cascadeOnUpdate();
            $table->tinyInteger('status_kawin')->nullable()->default(1);
            $table->tinyInteger('jenis_kelamin')->nullable()->default(1);
            $table->tinyInteger('status_keluarga')->nullable()->default(0);
            $table->json('unggah_foto')->nullable();
            $table->json('unggah_dokumen')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
