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
        Schema::create('percakapan', function (Blueprint $table) {
            $table->id();
            $table->text('isi_pesan');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('skripsi_id')->nullable();
            $table->string('session_token')->nullable();
            $table->foreign('skripsi_id')->references('id')->on('skripsi')->onDelete('cascade');
            $table->string('nama_pengirim', 70);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('percakapan', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['skripsi_id']);
        });
        Schema::dropIfExists('percakapan');
    }
};
