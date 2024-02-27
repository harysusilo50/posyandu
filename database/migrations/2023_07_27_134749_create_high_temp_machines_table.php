<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHighTempMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('high_temp_machines', function (Blueprint $table) {
            $table->id();
            $table->enum('meal_period', ['breakfast', 'lunch', 'dinner']);
            $table->integer('final_temp_rinse');
            $table->integer('temp_from_dishwasher');
            $table->longText('corrective_action')->nullable();
            $table->string('nama_petugas');
            $table->date('date');
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
        Schema::dropIfExists('high_temp_machines');
    }
}
