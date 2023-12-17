<?php
declare(strict_types=1);

use App\Models\JenisPsks;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sub_jenis_psks', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JenisPsks::class)
                ->nullable()
                ->constrained('jenis_psks')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('nama_sub_jenis');
            $table->string('alias')->nullable();
            $table->string('deskripsi')->nullable();
        });
    }
};
