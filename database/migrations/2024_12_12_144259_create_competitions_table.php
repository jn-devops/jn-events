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
        Schema::create('competitions', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('competition_participant', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('competition_id');
            $table->foreignId('participant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
        Schema::dropIfExists('competition_participant');
    }
};
