<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsForRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->smallInteger('year_of_birth')->nullable()->after('type');
            $table->enum('gender', ['M','F'])->nullable()->after('year_of_birth');
            $table->boolean('is_registered')->nullable()->after('gender');
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
            $table->dropColumn(['year_of_birth', 'gender', 'is_registered']);
        });
    }
}
