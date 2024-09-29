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
        Schema::create('user_coin_details', function (Blueprint $table) {
            $table->id();
            $table->enum('source', ['GAME', 'WEBSITE', 'INITIAL', 'BONUS', 'COIN_CONVERT'])->comment('GAME,WEBSITE,INITIAL,BONUS,COIN_CONVERT');
            $table->enum('coin_type', ['ADD', 'SUB'])->comment('ADD , SUB');
            $table->foreignId('user_coin_id');
            $table->foreign('user_coin_id')->on('user_coins')->references('id');
            $table->bigInteger('coin')->default(0);
            $table->foreignId('game_session_detail_id')->nullable();
            $table->foreignId('user_coin_convert_log_id')->nullable();
            $table->foreignId('website_id')->nullable();

            $table->foreignId('creator')->nullable();
            $table->foreign('game_session_detail_id')->on('game_session_details')->references('id');
            $table->foreign('user_coin_convert_log_id')->on('user_coin_convert_logs')->references('id');
            $table->foreign('website_id')->on('websites')->references('id');
            $table->foreign('creator')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_coin_details');
    }
};
