<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('users', static function (Blueprint $table): void {
            $table->string('instansi_id')->after('password')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('user', function (Blueprint $table): void {
        });
    }
};
