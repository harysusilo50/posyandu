<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image', 'description']);
            $table->enum('machine', ['manual_pot_sink', 'high_temp', 'ice_machine', 'daily_scoop']);
            $table->text('value');
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
        Schema::dropIfExists('machine_settings');
    }
}
