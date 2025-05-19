<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bantuan_ppks_detail_bantuan_ppks', function (Blueprint $table): void {
            $table->foreignId('bantuan_ppks_id')->index();
            $table->foreignId('detail_bantuan_ppks_id')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bantuan_ppks_detail_bantuan_ppks');
    }
};
