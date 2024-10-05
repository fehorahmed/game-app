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
        Schema::create('level_income_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['GAIN','LOSS']);
            $table->unsignedInteger('level_number');
            $table->foreignId('star_buyer_id');
            $table->foreignId('app_user_id');
            $table->unsignedInteger('star_number');
            $table->foreignId('amount');
            $table->unsignedFloat('star_price',8,2);
            $table->unsignedInteger('income_percent');
            $table->foreignId('star_log_id');

            $table->foreign('star_buyer_id')->on('app_users')->references('id');
            $table->foreign('app_user_id')->on('app_users')->references('id');
            $table->foreign('star_log_id')->references('id')->on('star_logs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_income_logs');
    }
};
