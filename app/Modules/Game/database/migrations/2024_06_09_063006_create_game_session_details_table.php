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
        Schema::create('game_session_details', function (Blueprint $table) {
            $table->id();
            $table->enum('coin_type', ['WIN', 'FEE', 'INIT','WISH']);
            $table->foreignId('game_session_id');
            $table->foreignId('app_user_id');
            $table->unsignedBigInteger('coin');
            $table->unsignedBigInteger('game_fee')->nullable();
            $table->unsignedInteger('game_fee_percentage')->nullable();
            $table->unsignedInteger('streak')->default(0);
            $table->string('remark')->nullable();
            $table->timestamps();

            $table->foreign('game_session_id')->on('game_sessions')->references('id');
            $table->foreign('app_user_id')->on('app_users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_session_details');
    }
};
