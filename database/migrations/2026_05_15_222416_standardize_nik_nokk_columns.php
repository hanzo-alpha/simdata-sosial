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
        Schema::table('bantuan_bpjs', function (Blueprint $table): void {
            $table->renameColumn('nik_tmt', 'nik');
            $table->renameColumn('nokk_tmt', 'nokk');
        });

        Schema::table('bantuan_bpnt', function (Blueprint $table): void {
            $table->renameColumn('no_nik', 'nik');
        });

        Schema::table('bantuan_pkh', function (Blueprint $table): void {
            $table->renameColumn('nik_ktp', 'nik');
        });

        Schema::table('penyaluran_bantuan_ppks', function (Blueprint $table): void {
            $table->renameColumn('no_kk', 'nokk');
        });

        Schema::table('penyaluran_bantuan_rastra', function (Blueprint $table): void {
            $table->renameColumn('nik_kpm', 'nik');
            $table->renameColumn('no_kk', 'nokk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bantuan_bpjs', function (Blueprint $table): void {
            $table->renameColumn('nik', 'nik_tmt');
            $table->renameColumn('nokk', 'nokk_tmt');
        });

        Schema::table('bantuan_bpnt', function (Blueprint $table): void {
            $table->renameColumn('nik', 'no_nik');
        });

        Schema::table('bantuan_pkh', function (Blueprint $table): void {
            $table->renameColumn('nik', 'nik_ktp');
        });

        Schema::table('penyaluran_bantuan_ppks', function (Blueprint $table): void {
            $table->renameColumn('nokk', 'no_kk');
        });

        Schema::table('penyaluran_bantuan_rastra', function (Blueprint $table): void {
            $table->renameColumn('nik', 'nik_kpm');
            $table->renameColumn('nokk', 'no_kk');
        });
    }
};
