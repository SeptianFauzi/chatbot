<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_user', function (Blueprint $table) {
            $table->unsignedBigInteger('topic_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('created_at');

            $table->primary(['topic_id', 'user_id']);
            $table->foreign('topic_id')->references('id')->on('topics');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topic_user');
    }
}
