<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->uuid('dtks_id')->nullable();
            $table->string('nokk');
            $table->string('nik');
            $table->string('nama_lengkap');
            $table->string('notelp');
            $table->string('tempat_lahir')->nullable();
            $table->dateTime('tgl_lahir')->nullable();
            $table->unsignedTinyInteger('status_family')->nullable();
            $table->timestamps();
        });
    }
};
