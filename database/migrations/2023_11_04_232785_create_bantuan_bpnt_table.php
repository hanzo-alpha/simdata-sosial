<?php

declare(strict_types=1);

use App\Models\JenisBantuan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bantuan_bpnt', static function (Blueprint $table): void {
            $table->id();
            $table->uuid('dtks_id')->default(Str::uuid()->toString());
            $table->string('nokk');
            $table->string('nik_ktp');
            $table->string('nama_penerima');
            $table->char('kode_wilayah', 10);
            $table->unsignedTinyInteger('tahap');
            $table->string('bansos');
            $table->foreignIdFor(JenisBantuan::class)
                ->constrained('jenis_bantuan')
                ->cascadeOnUpdate();
            $table->string('bank');
            $table->unsignedDouble('nominal', 20, 2)->nullable()->default(0);
            $table->char('provinsi', 2)->nullable();
            $table->char('kabupaten', 5)->nullable();
            $table->char('kecamatan', 7)->nullable();
            $table->char('kelurahan', 10)->nullable();
            $table->string('alamat');
            $table->string('no_rt')->nullable();
            $table->string('no_rw')->nullable();
            $table->string('dusun')->nullable();
            $table->string('dir')->nullable();
            $table->string('gelombang')->nullable();
            $table->year('tahun')->nullable()->default(now()->year);
            $table->string('status_bpnt')->nullable()->default('BPNT');
            $table->softDeletes();
            $table->timestamps();
        });
    }
};
