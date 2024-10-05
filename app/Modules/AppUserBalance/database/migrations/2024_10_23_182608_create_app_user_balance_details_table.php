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
        Schema::create('app_user_balance_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_user_balance_id');
            $table->enum('source', ['COIN_CONVERT', 'BALANCE_TRANSFER','DEPOSIT','WITHDRAW','STAR','LEVEL'])->comment('COIN_CONVERT,BALANCE_TRANSFER,DEPOSIT,WITHDRAW,STAR,LEVEL');
            $table->enum('balance_type', ['ADD', 'SUB'])->comment('ADD , SUB');
            $table->bigInteger('balance')->default(0);
            $table->foreignId('user_coin_convert_log_id')->nullable();
            $table->foreignId('balance_transfer_log_id')->nullable();
            $table->foreignId('deposit_log_id')->nullable();
            $table->foreignId('withdraw_log_id')->nullable();
            $table->foreignId('star_log_id')->nullable();
            $table->foreignId('level_income_log_id')->nullable();

            $table->foreign('app_user_balance_id')->on('app_user_balances')->references('id');
            $table->foreign('user_coin_convert_log_id')->on('user_coin_convert_logs')->references('id');
            $table->foreign('balance_transfer_log_id')->on('balance_transfer_logs')->references('id');
            $table->foreign('deposit_log_id')->on('deposit_logs')->references('id');
            $table->foreign('withdraw_log_id')->on('withdraw_logs')->references('id');
            $table->foreign('star_log_id')->on('star_logs')->references('id');
            $table->foreign('level_income_log_id')->on('level_income_logs')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_user_balance_details');
    }
};
