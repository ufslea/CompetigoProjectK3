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
            $table->unsignedBigInteger('sublomba_id');
            $table->unsignedBigInteger('partisipan_id');
            $table->integer('rank')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('sublomba_id')->references('sublomba_id')->on('sub_lomba')->onDelete('cascade');
            $table->foreign('partisipan_id')->references('partisipan_id')->on('partisipans')->onDelete('cascade');
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
