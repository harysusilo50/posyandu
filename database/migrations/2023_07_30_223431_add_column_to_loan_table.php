<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->integer('qty_return')->after('qty')->nullable();
            $table->renameColumn('signature', 'signature_borrowing');
            $table->string('signature_return')->after('signature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->renameColumn('signature_borrowing', 'signature');
            $table->dropColumn('qty_return');
            $table->dropColumn('signature_return');
        });
    }
}
