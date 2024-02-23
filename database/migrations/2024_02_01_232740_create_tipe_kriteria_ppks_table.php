<?php

use App\Models\BantuanPpks;
use App\Models\KriteriaPpks;
use App\Models\TipePpks;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('tipe_kriteria_ppks', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(TipePpks::class)
                ->nullable()
                ->constrained('tipe_ppks')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(KriteriaPpks::class)
                ->nullable()
                ->constrained('kriteria_ppks')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(BantuanPpks::class)
                ->nullable()
                ->constrained('bantuan_ppks')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipe_kriteria_ppks');
    }
};
