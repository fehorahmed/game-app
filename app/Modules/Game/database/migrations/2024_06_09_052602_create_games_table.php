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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('image')->nullable();
            $table->string('youtube_url')->nullable();
            $table->mediumText('text')->nullable();
            $table->boolean('status')->default(1);
            $table->foreignId('creator');
            $table->foreignId('updator')->nullable();
            $table->foreign('creator')->references('id')->on('users');
            $table->foreign('updator')->references('id')->on('users');
            $table->timestamps();
        });
        DB::table('games')->insert([
            'name' => 'LUDO',
            'creator' => 1
        ]);
        DB::table('games')->insert([
            'name' => 'POOL',
            'creator' => 1
        ]);
        DB::table('games')->insert([
            'name' => 'CARROM',
            'creator' => 1
        ]);
        DB::table('games')->insert([
            'name' => 'DOTANDBLOCK',
            'creator' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
