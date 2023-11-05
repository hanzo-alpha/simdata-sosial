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
        Schema::create('anggota', static function (Blueprint $table) {
            $table->id();
            $table->string('nokk');
            $table->string('nik');
            $table->string('nama_anggota');
            $table->bigInteger('alamat_id');
            $table->string('tempat_lahir');
            $table->string('tgl_lahir');
            $table->string('notelp');
            $table->foreignIdFor(JenisBantuan::class)
                ->constrained('jenis_bantuan')
                ->cascadeOnUpdate();
            $table->foreignIdFor(PendidikanTerakhir::class)
                ->constrained('pendidikan_terakhir')
                ->cascadeOnUpdate();
            $table->foreignIdFor(HubunganKeluarga::class)
                ->constrained('hubungan_keluarga')
                ->cascadeOnUpdate();
            $table->foreignIdFor(JenisPekerjaan::class)
                ->constrained('jenis_pekerjaan')
                ->cascadeOnUpdate();
            $table->tinyInteger('status_kawin')->nullable();
            $table->tinyInteger('jenis_kelamin')->nullable();
            $table->timestamps();
        });
    }
};
