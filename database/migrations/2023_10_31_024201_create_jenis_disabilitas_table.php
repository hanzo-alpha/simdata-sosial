<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenis_disabilitas', static function (Blueprint $table) {
            $table->id();
            $table->string('nama_penyandang');
            $table->string('alias')->nullable();
            $table->json('sub_jenis_disabilitas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_disabilitas');
    }
};
