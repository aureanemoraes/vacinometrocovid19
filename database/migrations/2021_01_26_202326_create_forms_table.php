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
            $table->string('cpf');
            $table->date('birthdate');
            $table->unsignedBigInteger('vacinationplace_id');
            $table->foreign('vacinationplace_id')->references('id')->on('vacination_places');
            $table->unsignedBigInteger('prioritygroup_id');
            $table->foreign('prioritygroup_id')->references('id')->on('priority_groups');
            $table->string('gender');
            $table->string('public_place');
            $table->string('place_number');
            $table->string('neighborhood');
            $table->string('state')->default('Amapá');
            $table->string('city');
            $table->tinyInteger('activeted')->default(0);

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
