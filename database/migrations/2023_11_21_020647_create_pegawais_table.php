<?php
declare(strict_types=1);

use App\Models\Kantor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pegawai', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Kantor::class)->constrained('kantor')->cascadeOnUpdate();
            $table->string('nama_pegawai');
            $table->string('nik_pegawai')->nullable();
            $table->string('jabatan');
            $table->string('no_telp')->nullable();
            $table->unsignedBigInteger('role_id')->nullable()->default(1);
            $table->tinyInteger('status_pegawai')->nullable();
            $table->timestamps();
        });
    }
};
