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
        Schema::create('website_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('website_id');
            $table->string('url');
            $table->unsignedBigInteger('time')->default(0)->comment('Time in second');
            $table->foreign('website_id')->on('websites')->references('id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_lists');
    }
};
