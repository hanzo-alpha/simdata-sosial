<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddAttributeChangesToActivityLogTable extends Migration
{
    public function up(): void
    {
        Schema::connection(config('activitylog.database_connection'))->table(
            config('activitylog.table_name'),
            static function (Blueprint $table): void {
                if (! Schema::hasColumn(config('activitylog.table_name'), 'attribute_changes')) {
                    $table->json('attribute_changes')->nullable()->after('log_name');
                }
            },
        );
    }

    public function down(): void
    {
        Schema::connection(config('activitylog.database_connection'))->table(
            config('activitylog.table_name'),
            static function (Blueprint $table): void {
                if (Schema::hasColumn(config('activitylog.table_name'), 'attribute_changes')) {
                    $table->dropColumn('attribute_changes');
                }
            },
        );
    }
}
