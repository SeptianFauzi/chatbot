<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempoQuizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempo_quiz', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('keyword', 255);
            $table->text('question');
            $table->string('optionA', 100);
            $table->string('optionB', 100);
            $table->string('optionC', 100);
            $table->string('optionD', 100);
            $table->string('asset', 255);
            $table->string('answer', 5);
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
        Schema::dropIfExists('tempo_quiz');
    }
}
