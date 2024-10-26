<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_attachments', function (Blueprint $table) {
            $table->id('state_attachment_id');
            $table->foreignId('state_tender_id')->onDelete('cascade')->index();
            $table->foreign('state_tender_id')->references('state_tender_id')->on('state_tenders');
            $table->text('attachment_name');
            $table->string('attachment_size', 100)->nullable();
            $table->date('attachment_date')->nullable();
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
        Schema::dropIfExists('state_attachments');
    }
}
