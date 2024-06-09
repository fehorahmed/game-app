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
        Schema::create('game_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id');

            $table->uuid('game_session')->unique();
            $table->foreignId('room_id');
            $table->foreignId('game_id');
            $table->unsignedBigInteger('board_amount');
            $table->unsignedTinyInteger('status')->comment('1=initial Game,0=End Game');
            $table->dateTime('init_time');
            $table->dateTime('end_time')->nullable();
            $table->timestamps();

            $table->foreign('host_id')->on('app_users')->references('id');
            $table->foreign('game_id')->on('games')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_sessions');
    }
};
