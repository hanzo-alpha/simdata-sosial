<?php
declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kantor', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnUpdate();
            $table->string('nama_kantor');
            $table->unsignedBigInteger('pegawai_id')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telp')->nullable();
        });
    }

    public function down(): void
    {
        Schema::drop('kantor');
    }
};
