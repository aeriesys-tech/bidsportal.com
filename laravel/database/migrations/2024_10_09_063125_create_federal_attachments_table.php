<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFederalAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('federal_attachments', function (Blueprint $table) {
            $table->id('federal_attachment_id');
            $table->foreignId('federal_tender_id')->onDelete('cascade')->index();
            $table->foreign('federal_tender_id')->references('federal_tender_id')->on('federal_tenders');
            $table->text('attachment_name');
            $table->string('attachment_size', 100)->nullable();
            $table->date('attachment_date')->nullable();
            $table->text('attachment_url', 255)->nullable();
            $table->text('attachment_s3_url', 255)->nullable();
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
        Schema::dropIfExists('federal_attachments');
    }
}
