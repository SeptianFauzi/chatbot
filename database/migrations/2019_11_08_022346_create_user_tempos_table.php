<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTemposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tempos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userId', 255);
            $table->string('displayName', 255);
            $table->string('pictureUrl', 255);
            $table->string('type', 10);
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
        Schema::dropIfExists('user_tempos');
    }
}
