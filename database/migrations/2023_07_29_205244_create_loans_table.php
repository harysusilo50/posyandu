<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('no_order');
            $table->foreignId('inventory_id')->constrained()->onDelete('cascade');
            $table->date('borrowing_date');
            $table->date('return_date');
            $table->enum('status', ['borrowed', 'returned', 'minus_return']);
            $table->string('borrowing_name');
            $table->string('return_name')->nullable();
            $table->integer('qty');
            $table->string('departmen');
            $table->string('signature');
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
        Schema::dropIfExists('loans');
    }
}
