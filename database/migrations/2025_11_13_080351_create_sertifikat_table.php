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
    $table->foreignId('partisipan_id')->constrained('partisipan', 'partisipan_id')->onDelete('cascade');
    $table->foreignId('sublomba_id')->constrained('sub_lomba', 'sublomba_id')->onDelete('cascade');
    $table->string('gambar');
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
