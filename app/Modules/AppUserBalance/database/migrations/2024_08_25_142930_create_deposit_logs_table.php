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
        Schema::create('deposit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_id');
            $table->foreign('payment_method_id')->on('payment_methods')->references('id');
            $table->foreignId('app_user_id');
            $table->foreign('app_user_id')->on('app_users')->references('id');
            $table->date('deposit_date');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('charge');
            $table->string('transaction_id');
            $table->enum('creator',['user','admin'])->default('user');
            $table->date('accept_date')->nullable();
            $table->foreignId('accept_by')->nullable();
            $table->foreign('accept_by')->on('users')->references('id');
            $table->foreignId('created_by');
            $table->unsignedTinyInteger('status')->default(1)->comment('1=Deposit Applied, 2 = Accept , 0 =Decline');
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_logs');
    }
};
