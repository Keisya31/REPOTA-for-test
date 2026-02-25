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
        Schema::create('skripsi', function (Blueprint $table) {
            $table->id();
            $table->char('nim', 14)->nullable();
            $table->foreign('nim')->references('nim')->on('mahasiswa')->nullOnDelete();
            $table->string('nama_mhs', 70);
            $table->string('nim_mhs', 70);
            $table->string('judul', 500);
            $table->text('abstrak');
            $table->string('path_file')->nullable();
            $table->string('path_hlm_depan')->nullable();
            $table->string('path_bab1')->nullable();
            $table->enum('tema', ['siscer', 'rpl', 'si', 'kv'])->nullable();
            $table->string('pembimbing_1', 70);
            $table->string('pembimbing_2', 70);
            $table->string('penguji_sidang', 70)->nullable();
            $table->date('tanggal_sidang')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Skripsi', function (Blueprint $table) {
            $table->dropForeign(['nim']);
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('skripsi');
    }
};
