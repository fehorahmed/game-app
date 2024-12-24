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
        Schema::create('own_website_visit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('own_website_id');
            $table->foreignId('app_user_id');
            $table->date('date');
            $table->unsignedBigInteger('coin')->default(0);

            $table->foreign('own_website_id')->on('own_websites')->references('id');
            $table->foreign('app_user_id')->on('app_users')->references('id');

            $table->timestamps();
            $table->unique(['own_website_id', 'app_user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('own_website_visit_logs');
    }
};
