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
        Schema::create('api_keys', function (Blueprint $table) {
            $table->bigIncrements('api_key_id');
            $table->string('api_key');
            $table->timestamps();
        });

        DB::table('api_keys')->insert([
            'api_key' => 'GAvJtZVt20tADeGIPb9KIbw0Nd0aBt3VlrxicslC'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};
