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
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('admin_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 50);
            $table->string('mobile1', 15);
            $table->string('mobile2', 15);
            $table->string('password', 255);
            $table->string('role', 15);
            $table->datetime('created_on');
            $table->datetime('last_login');
            $table->datetime('last_seen');
            $table->datetime('last_edited');
            $table->boolean('status');
            $table->string('real_password', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
