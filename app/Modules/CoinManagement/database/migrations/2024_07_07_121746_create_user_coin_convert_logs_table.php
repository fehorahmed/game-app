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
            $table->enum('convert_type',['COIN','BALANCE'])->default('COIN');
            $table->foreignId('app_user_id');
            $table->bigInteger('coin')->default(0);
            $table->bigInteger('coin_rate')->default(0);
            $table->double('balance', 20, 2)->default(0);

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
