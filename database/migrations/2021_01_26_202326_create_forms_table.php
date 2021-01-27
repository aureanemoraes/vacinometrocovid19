<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('age');
            $table->string('publicplace');
            $table->string('number');
            $table->string('neighborhood');
            $table->unsignedBigInteger('vacinationplace_id');
            $table->foreign('vacinationplace_id')->references('id')->on('vacination_places');
            //$table->string('vacination_place');
            $table->string('prioritygroup');
            $table->string('gender');
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
        Schema::dropIfExists('forms');
    }
}
