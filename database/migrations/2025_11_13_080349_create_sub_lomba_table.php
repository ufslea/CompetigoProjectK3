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
       Schema::create('sub_lomba', function (Blueprint $table) {
    $table->id('sublomba_id');
    $table->unsignedBigInteger('event_id');
    $table->string('nama');
    $table->string('kategori');
    $table->text('deskripsi')->nullable();
    $table->string('link')->nullable();
    $table->date('deadline')->nullable();
    $table->string('gambar')->nullable();
    $table->string('status')->default('aktif');
    $table->timestamps();

    $table->foreign('event_id')->references('events_id')->on('events')->onDelete('cascade');
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_lomba');
    }
};
