<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('penyaluran_bantuan_rastra', function (Blueprint $table): void {
            $table->text('keterangan')->nullable()->after('status_penyaluran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penyaluran_bantuan_rastra', function (Blueprint $table): void {
            $table->dropColumn('keterangan');
        });
    }
};
