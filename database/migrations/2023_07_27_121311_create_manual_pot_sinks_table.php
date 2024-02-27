<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualPotSinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_pot_sinks', function (Blueprint $table) {
            $table->id();
            $table->enum('meal_period', ['breakfast', 'lunch', 'dinner']);
            $table->integer('wash_temp');
            $table->integer('sanitizer_temp');
            $table->string('sanitizer_type');
            $table->string('sanitizer_strength');
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
        Schema::dropIfExists('manual_pot_sinks');
    }
}
