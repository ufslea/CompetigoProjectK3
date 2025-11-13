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
        Schema::create('hasil', function (Blueprint $table) {
    $table->id('hasil_id');
    $table->foreignId('sublomba_id')->constrained('sub_lomba', 'sublomba_id')->onDelete('cascade');
    $table->foreignId('partisipan_id')->constrained('partisipan', 'partisipan_id')->onDelete('cascade');
    $table->integer('rank')->nullable();
    $table->text('deskripsi')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil');
    }
};
