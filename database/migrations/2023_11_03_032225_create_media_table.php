<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if ( ! Schema::hasTable('media')) {
            Schema::create(app(config('curator.model'))->getTable(), function (Blueprint $table): void {
                $table->id();
                $table->string('disk')->default('public');
                $table->string('directory')->default('media');
                $table->string('visibility')->default('public');
                $table->string('name');
                $table->string('path');
                $table->unsignedInteger('width')->nullable();
                $table->unsignedInteger('height')->nullable();
                $table->unsignedInteger('size')->nullable();
                $table->string('type')->default('image');
                $table->string('ext');
                $table->string('alt')->nullable();
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->text('caption')->nullable();
                $table->text('exif')->nullable();
                $table->longText('curations')->nullable();
                $table->char('kelurahan', 10)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(app(config('curator.model'))->getTable());
    }
};
