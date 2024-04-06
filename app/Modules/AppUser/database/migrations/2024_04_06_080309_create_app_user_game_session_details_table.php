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
        Schema::create('app_user_game_session_details', function (Blueprint $table) {
            $table->id();
            $table->enum('coin_type', ['WIN', 'LOSS', 'BONUS']);
            $table->foreignId('app_user_game_session_id');
            $table->foreign('app_user_game_session_id')->on('app_user_game_sessions')->references('id');
            $table->bigInteger('coin');
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_user_game_session_details');
    }
};
