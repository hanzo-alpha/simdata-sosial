<?php

use App\Models\JenisBantuan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bantuan', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JenisBantuan::class)
                ->nullable()
                ->constrained('jenis_bantuan')
                ->cascadeOnDelete();
            $table->string('nama_bantuan');
            $table->string('alias')->nullable();
            $table->string('deskripsi')->nullable();
            $table->morphs('bantuanable');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bantuan');
    }
};
