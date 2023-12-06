<?php
declare(strict_types=1);

use App\Models\Bantuan;
use App\Models\Family;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bantuanables', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Family::class)->nullable()->constrained('family')->cascadeOnDelete();
            $table->foreignIdFor(Bantuan::class)->nullable()->constrained('bantuan')->cascadeOnDelete();
            $table->morphs('bantuanable');
            $table->timestamps();
        });
    }
};
