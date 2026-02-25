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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->char('nim', 14)->primary();
            $table->string('mhs_nama', 70);
            $table->char('status', 4)->default('BARU');
            $table->char('semester', 2);
            $table->char('kelas', 1)->default('A');
            $table->boolean('tugas_akhir')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
