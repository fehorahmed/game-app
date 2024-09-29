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
        Schema::create('star_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_user_id');
            $table->foreign('app_user_id')->on('app_users')->references('id');

            $table->dateTime('date');
            $table->unsignedFloat('price',8,2);
            $table->unsignedFloat('star_amount',8,2);

            $table->enum('creator',['user','admin'])->default('user');
            $table->foreignId('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('star_logs');
    }
};
