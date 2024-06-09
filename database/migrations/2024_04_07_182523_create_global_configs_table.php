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
        Schema::create('global_configs', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('updated_by')->on('users')->references('id');
            $table->timestamps();
        });
        DB::table('global_configs')->insert([
            array('id' => '1', 'key' => 'application_name', 'value' => 'Game Hub', 'created_by' => NULL, 'updated_by' => NULL),
            array('id' => '2', 'key' => 'application_email', 'value' => 'hub@gmail.com', 'created_by' => NULL, 'updated_by' => NULL),
            array('id' => '3', 'key' => 'company_name', 'value' => 'Game Hub', 'created_by' => NULL, 'updated_by' => NULL),
            array('id' => '4', 'key' => 'max_referral_user', 'value' => '5', 'created_by' => NULL, 'updated_by' => NULL),
            array('id' => '5', 'key' => 'company_address', 'value' => '28/A/2 Sonatangor Rd, Dhaka 1209', 'created_by' => NULL, 'updated_by' => NULL),
            array('id' => '6', 'key' => 'registration_bonus', 'value' => '0', 'created_by' => NULL, 'updated_by' => NULL),
            array('id' => '7', 'key' => 'game_initialize_coin_amount', 'value' => '1000', 'created_by' => NULL, 'updated_by' => NULL),
            array('id' => '8', 'key' => 'game_win_coin_deduct_percentage', 'value' => '5', 'created_by' => NULL, 'updated_by' => NULL)
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_configs');
    }
};
