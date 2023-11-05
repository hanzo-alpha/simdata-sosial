<?php

use App\Models\Alamat;
use App\Models\Keluarga;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alamat_keluarga', static function (Blueprint $table) {
            $table->foreignIdFor(Alamat::class)->constrained('alamat')->cascadeOnUpdate();
            $table->foreignIdFor(Keluarga::class)->constrained('keluarga')->cascadeOnUpdate();
        });
    }
};
