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
        Schema::create('badminton_court_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('badminton_court_id');
            $table->foreign('badminton_court_id')->references('id')->on('badminton_courts')->onDelete('cascade');
            $table->string('date');
            $table->string('empty_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badminton_court_schedules');
    }
};
