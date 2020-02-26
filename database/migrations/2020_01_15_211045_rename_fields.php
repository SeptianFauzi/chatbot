<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('userId', 'line_id');
            $table->renameColumn('displayName', 'display_name');
            $table->renameColumn('pictureUrl', 'picture_url');
        });

        Schema::table('flow', function (Blueprint $table) {
            $table->renameColumn('userId', 'line_id');
            $table->renameColumn('flowName', 'flow_name');
            $table->renameColumn('lastTopic', 'last_topic');
            $table->renameColumn('nextTopic', 'next_topic');
        });

        Schema::table('log_quiz', function (Blueprint $table) {
            $table->renameColumn('userId', 'line_id');
            $table->renameColumn('topicQuiz', 'topic_quiz');
            $table->renameColumn('countFailed', 'count_failed');
            $table->renameColumn('isUnique', 'is_unique');
        });

        Schema::table('tempo_quiz', function (Blueprint $table) {
            $table->renameColumn('optionA', 'option_a');
            $table->renameColumn('optionB', 'option_b');
            $table->renameColumn('optionC', 'option_c');
            $table->renameColumn('optionD', 'option_d');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('line_id', 'userId');
            $table->renameColumn('display_name', 'displayName');
            $table->renameColumn('picture_url', 'pictureUrl');
        });

        Schema::table('flow', function (Blueprint $table) {
            $table->renameColumn('line_id', 'userId');
            $table->renameColumn('flow_name', 'flowName');
            $table->renameColumn('last_topic', 'lastTopic');
            $table->renameColumn('next_topic', 'nextTopic');
        });

        Schema::table('log_quiz', function (Blueprint $table) {
            $table->renameColumn('line_id', 'userId');
            $table->renameColumn('topic_quiz', 'topicQuiz');
            $table->renameColumn('count_failed', 'countFailed');
            $table->renameColumn('is_unique', 'isUnique');
        });

        Schema::table('tempo_quiz', function (Blueprint $table) {
            $table->renameColumn('option_a', 'optionA');
            $table->renameColumn('option_b', 'optionB');
            $table->renameColumn('option_c', 'optionC');
            $table->renameColumn('option_d', 'optionD');
        });
    }
}
