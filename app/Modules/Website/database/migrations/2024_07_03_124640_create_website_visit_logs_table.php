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
        Schema::create('website_visit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id');
            $table->foreignId('app_user_id');
            $table->date('date');
            $table->unsignedBigInteger('coin')->default(0);

            $table->foreign('website_id')->on('websites')->references('id');
            $table->foreign('app_user_id')->on('app_users')->references('id');

            $table->timestamps();
            $table->unique(['website_id', 'app_user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_visit_logs');
    }
};
