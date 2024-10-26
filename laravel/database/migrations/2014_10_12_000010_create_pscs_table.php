<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePscsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pscs', function (Blueprint $table) {
            $table->id('psc_id');
            $table->foreignId('psc_parent_id')->nullable()->onDelete('cascade')->index();
            $table->foreign('psc_parent_id')->references('psc_id')->on('pscs');
            $table->string('psc_code', 50)->index();
            $table->string('psc_description', 255)->index();
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
        Schema::dropIfExists('pscs');
    }
}
