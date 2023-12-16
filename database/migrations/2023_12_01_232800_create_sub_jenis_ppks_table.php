<?php
declare(strict_types=1);

use App\Models\JenisPpks;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sub_jenis_ppks', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JenisPpks::class)
                ->nullable()
                ->constrained('jenis_ppks')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('nama_sub');
            $table->string('alias')->nullable();
            $table->string('deskripsi')->nullable();
        });
    }
};
