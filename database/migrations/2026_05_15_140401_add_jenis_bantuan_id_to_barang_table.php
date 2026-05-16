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
        if ( ! Schema::hasColumn('barang', 'jenis_bantuan_id')) {
            Schema::table('barang', function (Blueprint $table): void {
                $table->unsignedBigInteger('jenis_bantuan_id')->index()->nullable()->after('keterangan');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table): void {
            $table->dropColumn('jenis_bantuan_id');
        });
    }
};
