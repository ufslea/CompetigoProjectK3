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
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id('sertifikat_id');
            $table->unsignedBigInteger('partisipan_id');
            $table->unsignedBigInteger('sublomba_id');
            $table->string('gambar');
            $table->timestamps();

            $table->foreign('partisipan_id')->references('partisipan_id')->on('partisipans')->onDelete('cascade');
            $table->foreign('sublomba_id')->references('sublomba_id')->on('sub_lomba')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
