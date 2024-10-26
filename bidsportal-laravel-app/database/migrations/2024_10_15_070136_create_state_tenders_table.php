<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_tenders', function (Blueprint $table) {
            $table->id('state_tender_id');
            $table->string('tender_no', 255)->index();
            $table->string('title', 255)->index();
            $table->text('description')->index();
            $table->date('opening_date')->index();
            $table->timestamp('posted_date')->nullable()->index();
            $table->timestamp('expiry_date')->nullable()->index();
            $table->foreignId('country_id')->nullable()->index();
            $table->foreign('country_id')->references('country_id')->on('countries');
            $table->foreignId('state_id')->nullable()->index();
            $table->foreign('state_id')->references('state_id')->on('states');
            $table->foreignId('tender_type_id')->nullable()->index();
            $table->foreign('tender_type_id')->references('tender_type_id')->on('tender_types');
            $table->foreignId('state_notice_id')->nullable()->index();
            $table->foreign('state_notice_id')->references('state_notice_id')->on('state_notices');
            $table->foreignId('category_id')->nullable()->index();
            $table->foreign('category_id')->references('category_id')->on('categories');
            $table->foreignId('state_agency_id')->nullable()->index();
            $table->foreign('state_agency_id')->references('state_agency_id')->on('state_agencies');
            $table->foreignId('set_aside_id')->nullable()->index();
            $table->foreign('set_aside_id')->references('set_aside_id')->on('set_asides');
            $table->foreignId('naics_id')->nullable()->index();
            $table->foreign('naics_id')->references('naics_id')->on('naics');
            $table->foreignId('psc_id')->nullable()->index();
            $table->foreign('psc_id')->references('psc_id')->on('pscs');
            $table->string('tender_url', 255)->nullable();
            $table->double('fees')->nullable();
            $table->string('type_of_award', 255)->nullable();
            $table->string('place_of_performance', 255)->nullable();
            $table->string('notice_id', 255)->nullable();
            $table->text('description_link')->nullable();
            $table->string('category_name',255)->nullable();
            $table->string('notice_name', 255)->nullable();
            $table->string('agency_name', 255)->nullable();
            $table->string('document_path', 255)->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('state_tenders');
    }
}
