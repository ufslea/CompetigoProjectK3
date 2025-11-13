<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partisipan', function (Blueprint $table) {
            $table->id('partisipan_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sublomba_id');
            $table->string('institusi')->nullable();
            $table->string('kontak')->nullable();
            $table->string('file_karya')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('registered_at')->useCurrent();

            // Foreign keys
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('sublomba_id')->references('sublomba_id')->on('sub_lomba')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partisipan');
    }
};
