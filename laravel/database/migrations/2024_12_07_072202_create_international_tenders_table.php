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
        Schema::create('international_tenders', function (Blueprint $table) {
            $table->bigIncrements('international_tender_id');
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
            $table->foreignId('international_notice_id')->nullable()->index();
            $table->foreign('international_notice_id')->references('international_notice_id')->on('international_notices');
            $table->foreignId('category_id')->nullable()->index();
            $table->foreign('category_id')->references('category_id')->on('categories');
            $table->foreignId('international_agency_id')->nullable()->index();
            $table->foreign('international_agency_id')->references('international_agency_id')->on('international_agencies');
            $table->string('tender_url', 255)->nullable();
            $table->double('fees')->nullable();
            $table->string('type_of_award', 255)->nullable();
            $table->string('place_of_performance', 255)->nullable();
            $table->text('contracting_office_address')->nullable();
            $table->string('notice_id', 255)->nullable();
            $table->text('description_link')->nullable();
            $table->text('category_name')->nullable();
            $table->string('notice_name', 255)->nullable();
            $table->string('agency_name', 255)->nullable();
            $table->string('document_path', 255)->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_tenders');
    }
};
