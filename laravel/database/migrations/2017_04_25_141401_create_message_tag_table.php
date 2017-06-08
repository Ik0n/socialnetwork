<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_tag', function (Blueprint $table) {
            $table->integer('message_id')
                    ->unsigned();
            $table->foreign('message_id')
                    ->references('id')
                    ->on('messages')
                    ->onDelete('CASCADE')
                    ->onUpdate('RESTRICT');

            $table->integer('tag_id')
                    ->unsigned();
            $table->foreign('tag_id')
                    ->references('id')
                    ->on('tags')
                    ->onDelete('CASCADE')
                    ->onUpdate('RESTRICT');

            $table->primary(['message_id', 'tag_id']);

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
        Schema::dropIfExists('message_tag');
    }
}
