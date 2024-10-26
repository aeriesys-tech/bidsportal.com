<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFederalContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('federal_contacts', function (Blueprint $table) {
            $table->id('federal_contact_id');
            $table->foreignId('federal_tender_id')->onDelete('cascade')->index();
            $table->foreign('federal_tender_id')->references('federal_tender_id')->on('federal_tenders');
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
        Schema::dropIfExists('federal_contacts');
    }
}
