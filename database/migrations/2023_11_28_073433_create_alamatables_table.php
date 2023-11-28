<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alamatables', static function (Blueprint $table) {
            $table->foreignId('alamat_id');
            $table->morphs('alamatable');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alamatables');
    }
};
