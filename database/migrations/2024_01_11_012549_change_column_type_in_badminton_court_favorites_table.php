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
            $table->unsignedBigInteger('badminton_court_id')->change();
            $table->unsignedBigInteger('user_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('badminton_court_favorites', function (Blueprint $table) {
            $table->integer('badminton_court_id')->change();
            $table->integer('user_id')->change();
        });
    }
};
