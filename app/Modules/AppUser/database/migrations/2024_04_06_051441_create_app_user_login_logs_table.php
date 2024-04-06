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
        Schema::create('app_user_login_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('login_type', ['APP', 'GAME']);
            $table->enum('game_name', ['LUDO', 'POOL', 'CARROM', 'DOTANDBLOCK'])->nullable();
            $table->foreignId('app_user_id');
            $table->foreign('app_user_id')->on('app_users')->references('id');

            $table->string('ip_address');
            $table->string('session_id');
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('browser_name');
            $table->string('browser_version');
            $table->string('mac_address');
            $table->string('device_type');
            $table->string('operating_system');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_user_login_logs');
    }
};
