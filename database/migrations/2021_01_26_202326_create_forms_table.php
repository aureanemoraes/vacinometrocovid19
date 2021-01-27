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
            $table->string('public_place');
            $table->string('number');
            $table->string('neighborhood');
            //$table->unsignedBigInteger('vacination_place_id');
            //$table->foreign('vacination_place_id')->references('id')->on('vacination_places');
            $table->string('vacination_place');

            $table->string('priority_group');
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
