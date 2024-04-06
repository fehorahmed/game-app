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
        Schema::create('app_user_game_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_user_id');
            $table->foreign('app_user_id')->on('app_users')->references('id');
            $table->uuid('session')->unique();
            $table->enum('game_name', ['LUDO', 'POOL', 'CARROM', 'DOTANDBLOCK'])->nullable();
            $table->unsignedTinyInteger('status')->comment('1=initial Game,0=End Game');
            $table->dateTime('init_time');
            $table->dateTime('end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_user_game_sessions');
    }
};
