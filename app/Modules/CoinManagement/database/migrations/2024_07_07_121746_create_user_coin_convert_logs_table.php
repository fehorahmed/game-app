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
        Schema::create('user_coin_convert_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_user_id');
            $table->bigInteger('coin')->default(0);
            $table->bigInteger('coin_rate')->default(0);
            $table->bigInteger('balance')->default(0);

            $table->foreign('app_user_id')->on('app_users')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_coin_convert_logs');
    }
};
