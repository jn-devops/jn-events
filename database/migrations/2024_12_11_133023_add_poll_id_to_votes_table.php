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
        Schema::table('votes', function (Blueprint $table) {
//            $table->uuid('poll_id')->after('id'); // Add poll_id column
//            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade'); // Set foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
//            $table->dropForeign(['poll_id']); // Drop foreign key
//            $table->dropColumn('poll_id'); // Drop poll_id column
        });
    }
};
