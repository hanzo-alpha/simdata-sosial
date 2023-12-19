<?php
declare(strict_types=1);

use App\Models\BantuanBpjs;
use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('keluarga_penerima_manfaat', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BantuanBpjs::class)
                ->nullable()
                ->constrained('bantuan_bpjs')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(BantuanRastra::class)
                ->nullable()
                ->constrained('bantuan_rastra')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(BantuanPpks::class)
                ->nullable()
                ->constrained('bantuan_ppks')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(BantuanPkh::class)
                ->nullable()
                ->constrained('bantuan_pkh')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(BantuanBpnt::class)
                ->nullable()
                ->constrained('bantuan_bpnt')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unsignedBigInteger('jenis_bantuan_id')->nullable();
            $table->string('status_kpm')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }
};
