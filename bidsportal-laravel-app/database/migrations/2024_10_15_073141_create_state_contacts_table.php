<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_contacts', function (Blueprint $table) {
            $table->id('state_contact_id');
            $table->foreignId('state_tender_id')->onDelete('cascade')->index();
            $table->foreign('state_tender_id')->references('state_tender_id')->on('state_tenders');
            $table->string('type', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('full_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('state_contacts');
    }
}
