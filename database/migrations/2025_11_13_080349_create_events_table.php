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
        Schema::create('events', function (Blueprint $table) {
    $table->id('events_id');
    $table->foreignId('organizer_id')->constrained('users', 'user_id')->onDelete('cascade');
    $table->string('nama');
    $table->text('deskripsi')->nullable();
    $table->string('url')->nullable();
    $table->date('tanggal_mulai');
    $table->date('tanggal_akhir');
    $table->string('status')->default('aktif');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
