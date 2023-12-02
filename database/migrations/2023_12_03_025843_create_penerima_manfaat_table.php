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
        Schema::create('penerima_manfaat', function (Blueprint $table) {
            $table->id();
            $table->morphs('alamatable');
            $table->uuid('dtks_id')->nullable()->default(Str::uuid()->toString());
            $table->string('nokk', 20);
            $table->string('nik', 20);
            $table->string('nama_lengkap');
            $table->string('tempat_lahir', 50);
            $table->dateTime('tgl_lahir');
            $table->string('notelp', 18);
            $table->string('alamat_penerima')->default('Jalan Salotungo No. 10');
            $table->string('no_rt')->nullable();
            $table->string('no_rw')->nullable();
            $table->string('dusun')->nullable();
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('kodepos')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('nama_ibu_kandung');
            $table->morphs('bantuanable');
            $table->foreignIdFor(JenisBantuan::class)
                ->nullable()
                ->constrained('jenis_bantuan')
                ->cascadeOnDelete();
            $table->foreignIdFor(PendidikanTerakhir::class)
                ->nullable()
                ->constrained('pendidikan_terakhir')
                ->cascadeOnDelete();
            $table->foreignIdFor(HubunganKeluarga::class)
                ->nullable()
                ->constrained('hubungan_keluarga')
                ->cascadeOnDelete();
            $table->foreignIdFor(JenisPekerjaan::class)
                ->nullable()
                ->constrained('jenis_pekerjaan')
                ->cascadeOnDelete();
            $table->tinyInteger('status_kawin')
                ->nullable()
                ->default(1);
            $table->tinyInteger('jenis_kelamin')
                ->nullable()
                ->default(1);
            $table->tinyInteger('status_keluarga')
                ->nullable()
                ->default(0);
            $table->json('unggah_foto')->nullable();
            $table->json('unggah_dokumen')->nullable();

            $table->string('alamat_lengkap_penerima')->virtualAs("CONCAT(alamat_penerima, ', ',
             'RT. ' ,no_rt, ', ', 'RW. ', no_rw, ', ', dusun, ' ', kodepos)");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerima_manfaat');
    }
};
