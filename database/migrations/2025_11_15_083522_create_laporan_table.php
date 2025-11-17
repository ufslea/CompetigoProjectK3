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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('laporan_id');
            $table->unsignedBigInteger('pelapor_id');
            $table->unsignedBigInteger('events_id');
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->enum('status', ['pending', 'processed', 'finished', 'refused'])->default('pending');
            $table->string('bukti')->nullable();
            $table->text('tanggapan')->nullable();
            $table->timestamps();

            $table->foreign('pelapor_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('events_id')->references('events_id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
