<?php

declare(strict_types=1);

use App\Models\BantuanPpks;
use App\Models\KriteriaPpks;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bantuan_ppks_kriteria_ppks', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(BantuanPpks::class)->index();
            $table->foreignIdFor(KriteriaPpks::class)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bantuan_ppks_kriteria_ppks');
    }
};
