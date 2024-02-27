<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToIceMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ice_machines', function (Blueprint $table) {
            $table->enum('meal_period', ['breakfast', 'lunch', 'dinner'])->after('nama_petugas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ice_machines', function (Blueprint $table) {
            $table->dropColumn('nama_petugas');
        });
    }
}
