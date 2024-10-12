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
        Schema::create('app_user_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_user_id')->unique();
            $table->foreign('app_user_id')->on('app_users')->references('id');
            $table->double('balance', 20, 2)->default(0);
            $table->unsignedInteger('star')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_user_balances');
    }
};
