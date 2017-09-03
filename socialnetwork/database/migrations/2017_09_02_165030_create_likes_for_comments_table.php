<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesForCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes_for_comments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('comment_id')
                ->unsigned();
            $table->foreign('comment_id')
                ->references('id')
                ->on('comments')
                ->onDelete('CASCADE')
                ->onUpdate('RESTRICT');

            $table->integer('user_id')
                ->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE')
                ->onUpdate('RESTRICT');
            $table->softDeletes();
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
        Schema::dropIfExists('likes_for_comments');
    }
}
