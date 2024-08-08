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
        Schema::create('balance_transfer_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('given_by');
            $table->foreignId('received_by');
            $table->bigInteger('balance')->default(0);

            $table->foreign('given_by')->on('app_users')->references('id');
            $table->foreign('received_by')->on('app_users')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance_transfer_logs');
    }
};
