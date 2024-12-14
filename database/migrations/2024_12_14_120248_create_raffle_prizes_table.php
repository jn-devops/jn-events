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
        Schema::create('raffle_prizes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('raffle_id');
            $table->string('prize_name');
            $table->string('image')->nullable();
            $table->integer('quantity')->default(1);
            $table->json('companies')->nullable();
            $table->json('units')->nullable();
            $table->timestamps();

            $table->foreign('raffle_id')->references('id')->on('raffles')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffle_prizes');
    }
};
