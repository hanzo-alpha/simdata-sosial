<?php

declare(strict_types=1);

use App\Models\BansosDiterima;
use App\Models\BantuanPpks;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bantuan_ppks_bansos_diterima', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(BantuanPpks::class)->nullable()
                ->constrained('bantuan_ppks')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(BansosDiterima::class)->nullable()
                ->constrained('bansos_diterima')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bantuan_ppks_bansos_diterima');
    }
};
