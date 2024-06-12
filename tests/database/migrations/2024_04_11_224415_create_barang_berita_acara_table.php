<?php

declare(strict_types=1);

use App\Models\Barang;
use App\Models\BeritaAcara;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('barang_berita_acara', static function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Barang::class);
            $table->foreignIdFor(BeritaAcara::class);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_berita_acara');
    }
};
