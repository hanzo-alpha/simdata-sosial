<?php

use App\Models\BantuanPpks;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bansos_diterima', static function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(BantuanPpks::class)
                ->nullable()
                ->constrained('bantuan_ppks')
                ->cascadeOnUpdate();
            $table->string('nama_bansos');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bansos_diterima');
    }
};
