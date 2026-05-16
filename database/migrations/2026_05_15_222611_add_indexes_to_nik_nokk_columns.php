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
            $table->index('nik');
            $table->index('nokk');
        });

        Schema::table('bantuan_bpnt', function (Blueprint $table): void {
            $table->index('nik');
        });

        Schema::table('bantuan_pkh', function (Blueprint $table): void {
            $table->index('nik');
            $table->index('nokk');
        });

        Schema::table('bantuan_ppks', function (Blueprint $table): void {
            $table->index('nik');
            $table->index('nokk');
        });

        Schema::table('bantuan_rastra', function (Blueprint $table): void {
            $table->index('nik');
            $table->index('nokk');
        });

        Schema::table('peserta_bpjs', function (Blueprint $table): void {
            $table->index('nik');
        });

        Schema::table('penyaluran_bantuan_ppks', function (Blueprint $table): void {
            $table->index('nik');
            $table->index('nokk');
        });

        Schema::table('penyaluran_bantuan_rastra', function (Blueprint $table): void {
            $table->index('nik');
            $table->index('nokk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bantuan_bpjs', function (Blueprint $table): void {
            $table->dropIndex(['nik']);
            $table->dropIndex(['nokk']);
        });

        Schema::table('bantuan_bpnt', function (Blueprint $table): void {
            $table->dropIndex(['nik']);
        });

        Schema::table('bantuan_pkh', function (Blueprint $table): void {
            $table->dropIndex(['nik']);
            $table->dropIndex(['nokk']);
        });

        Schema::table('bantuan_ppks', function (Blueprint $table): void {
            $table->dropIndex(['nik']);
            $table->dropIndex(['nokk']);
        });

        Schema::table('bantuan_rastra', function (Blueprint $table): void {
            $table->dropIndex(['nik']);
            $table->dropIndex(['nokk']);
        });

        Schema::table('peserta_bpjs', function (Blueprint $table): void {
            $table->dropIndex(['nik']);
        });

        Schema::table('penyaluran_bantuan_ppks', function (Blueprint $table): void {
            $table->dropIndex(['nik']);
            $table->dropIndex(['nokk']);
        });

        Schema::table('penyaluran_bantuan_rastra', function (Blueprint $table): void {
            $table->dropIndex(['nik']);
            $table->dropIndex(['nokk']);
        });
    }
};
