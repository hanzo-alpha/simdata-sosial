<?php

declare(strict_types=1);

use App\Models\JenisBantuan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bantuan', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(JenisBantuan::class)
                ->nullable()
                ->constrained('jenis_bantuan')
                ->cascadeOnDelete();
            $table->string('nama_bantuan')->nullable();
            $table->morphs('bantuanable');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bantuan');
    }
};
