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
        Schema::create('game_boards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id');
            $table->unsignedBigInteger('board_amount');
            $table->boolean('status')->default(1);
            $table->foreignId('creator');
            $table->foreignId('updator')->nullable();
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('creator')->references('id')->on('users');
            $table->foreign('updator')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_boards');
    }
};
