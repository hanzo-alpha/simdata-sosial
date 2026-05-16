<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('media') && ! Schema::hasTable('curator')) {
            Schema::rename('media', 'curator');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('curator') && ! Schema::hasTable('media')) {
            Schema::rename('curator', 'media');
        }
    }
};
