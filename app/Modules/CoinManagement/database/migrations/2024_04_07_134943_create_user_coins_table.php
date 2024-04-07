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
        Schema::create('user_coins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_user_id')->unique();
            $table->foreign('app_user_id')->on('app_users')->references('id');
            $table->bigInteger('coin')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_coins');
    }
};
