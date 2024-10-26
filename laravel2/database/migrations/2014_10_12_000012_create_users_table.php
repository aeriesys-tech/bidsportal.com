<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('name', 100)->index();
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100);
            $table->string('position', 500);
            $table->string('company', 100);
            $table->string('phone', 50);
            $table->string('web_address', 100);
            $table->string('mailing_address', 100);
            $table->string('city', 50);
            $table->string('state', 50);
            $table->string('pin_code', 50);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('users')->insert([
            'name' => 'Bidsportal Team',
            'email' => 'support@bidsportal.com',
            'password' => Hash::make('nazim12345%'),
            'position' => 'Manager',
            'Company' => 'Bidsportal',
            'phone' => '9535342875',
            'web_address' => 'www.company_name.com',
            'mailing_address' => 'www.company_name.com',
            'city' => 'Bgm',
            'state' => 'Kar',
            'pin_code' => '590001'
        ]);   

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
