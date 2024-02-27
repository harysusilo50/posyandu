<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSubmissionColumnToListTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('list_tasks', function (Blueprint $table) {
            $table->string('submission')->after('status');
            $table->integer('grading')->after('submission')->nullable();
            $table->longText('description')->after('grading')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('list_tasks', function (Blueprint $table) {
            $table->dropColumn('submission');
            $table->dropColumn('grading');
            $table->dropColumn('description');
        });
    }
}
