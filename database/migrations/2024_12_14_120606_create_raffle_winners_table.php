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
        Schema::create('raffle_winners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('raffle_id');
            $table->uuid('raffle_prize_id');
            $table->uuid('participant_id');
            $table->unsignedInteger('employee_id');
            $table->timestamps();

            $table->foreign('raffle_id')->references('id')->on('raffles')->cascadeOnDelete();
            $table->foreign('raffle_prize_id')->references('id')->on('raffle_prizes')->cascadeOnDelete();
            $table->foreign('participant_id')->references('id')->on('raffle_participants')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffle_winners');
    }
};
