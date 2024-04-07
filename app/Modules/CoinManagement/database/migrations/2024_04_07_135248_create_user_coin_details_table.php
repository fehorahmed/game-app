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
            $table->enum('source', ['GAME', 'WEBSITE', 'INITIAL'])->comment('GAME,WEBSITE,INITIAL');
            $table->enum('coin_type', ['ADD', 'SUB'])->comment('ADD , SUB');
            $table->foreignId('user_coin_id');
            $table->foreign('user_coin_id')->on('user_coins')->references('id');
            $table->bigInteger('coin')->default(0);
            $table->foreignId('app_user_game_session_detail_id')->nullable();
            $table->foreign('app_user_game_session_detail_id')->on('app_user_game_session_details')->references('id');
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
