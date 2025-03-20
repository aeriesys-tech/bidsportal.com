<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('state_agencies', function (Blueprint $table) {
            $table->string('state_agency_name', 2048)->change();
        });
    }

    public function down(): void
    {
        Schema::table('state_agencies', function (Blueprint $table) {
            $table->string('state_agency_name', 255)->change();
        });
    }
};
