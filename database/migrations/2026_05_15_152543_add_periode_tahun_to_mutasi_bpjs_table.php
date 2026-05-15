<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mutasi_bpjs', function (Blueprint $table) {
            if (!Schema::hasColumn('mutasi_bpjs', 'periode_tahun')) {
                $table->year('periode_tahun')->nullable()->after('periode_bulan');
            }
            if (!Schema::hasColumn('mutasi_bpjs', 'no_surat_kematian')) {
                $table->string('no_surat_kematian', 50)->nullable()->after('status_mutasi');
            }
            if (!Schema::hasColumn('mutasi_bpjs', 'media_id')) {
                $table->foreignId('media_id')->nullable()->after('no_surat_kematian');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mutasi_bpjs', function (Blueprint $table) {
            $table->dropColumn(['periode_tahun', 'no_surat_kematian', 'media_id']);
        });
    }
};
