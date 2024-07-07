<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('account_no');
            $table->string('account_type')->nullable();
            $table->unsignedInteger('transaction_fee')->comment('Proti Hazar a');
            $table->string('logo')->nullable();
            $table->boolean('status')->default(1)->comment('1=active, 0=inactive');
            $table->timestamps();
        });
        DB::table('payment_methods')->insert([
            'name' => 'BKASH',
            'account_no' => '01750637286',
            'account_type' => 'Personal',
            'transaction_fee' => 10,
            'logo' => null,
            'status' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
