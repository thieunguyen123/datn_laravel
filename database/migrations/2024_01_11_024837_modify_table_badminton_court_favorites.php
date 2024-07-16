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
        Schema::table('badminton_court_favorites', function (Blueprint $table) {
            $table->foreign('badminton_court_id')->references('id')->on('badminton_courts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('badminton_court_favorites', function (Blueprint $table) {
            $table->dropForeign(['badminton_court_id']);
            $table->dropForeign(['user_id']);
        });
    }
};
