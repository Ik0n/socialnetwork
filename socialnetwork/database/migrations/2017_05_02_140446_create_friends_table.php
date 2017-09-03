<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->integer('user_id1')
                  ->unsigned();
            $table->foreign('user_id1')
                    ->references('id')
                    ->on('users')
                    ->onDelete('CASCADE')
                    ->onUpdate('RESTRICT');

            $table->integer('user_id2')
                ->unsigned();
            $table->foreign('user_id2')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE')
                ->onUpdate('RESTRICT');

            $table->primary(['user_id1', 'user_id2']);
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
        Schema::dropIfExists('friends');
    }
}
