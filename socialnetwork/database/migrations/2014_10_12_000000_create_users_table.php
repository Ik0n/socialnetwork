<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)
                  ->unique();
            $table->string('email', 191)
                ->unique();
            $table->string('password', 191);
            $table->string('number', 191);
            $table->string('first_name', 191);
            $table->string('last_name', 191);
            $table->string('third_name', 191);
            
            $table->string('country', 191);
            $table->string('city', 191);
            $table->string('filename', 191);
            $table->string('admin', 1);

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
