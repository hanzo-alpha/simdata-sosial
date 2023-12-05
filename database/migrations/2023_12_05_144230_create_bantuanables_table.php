<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bantuanables', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor('family_id')->nullable()->constrained('family')->cascadeOnDelete();
            $table->foreignIdFor('bantuan_id')->nullable()->constrained('bantuan')->cascadeOnDelete();
            $table->morphs('bantuanable');
            $table->timestamps();
        });
    }
};
