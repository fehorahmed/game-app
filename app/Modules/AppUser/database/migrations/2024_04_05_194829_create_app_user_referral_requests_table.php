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
        Schema::create('app_user_referral_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_user_id');
            $table->foreignId('requested_app_user_id');
            $table->enum('type', ['ACCEPT', 'REJECT'])->nullable();
            $table->boolean('status')->default(1)->comment('1=Active,0=Inactive');

            $table->foreign('app_user_id')->on('app_users')->references('id');
            $table->foreign('requested_app_user_id')->on('app_users')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_user_referral_requests');
    }
};
