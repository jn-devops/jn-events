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
        Schema::create('poll_options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('poll_id');
            $table->string('option');
            $table->timestamps();

            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poll_options');
    }
};
