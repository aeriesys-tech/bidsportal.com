<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNaicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('naics', function (Blueprint $table) {
            $table->id('naics_id');
            $table->foreignId('naics_parent_id')->nullable()->onDelete('cascade')->index();
            $table->foreign('naics_parent_id')->references('naics_id')->on('naics');
            $table->string('naics_code', 50)->index();
            $table->string('naics_description', 255)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('naics');
    }
}
