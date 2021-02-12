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
            $table->string('name')->nullable();
            $table->string('cpf')->nullable()->unique();
            $table->string('email')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('age')->nullable();
            $table->unsignedBigInteger('vacinationplace_id')->nullable();
            $table->foreign('vacinationplace_id')->references('id')->on('vacination_places');
            $table->unsignedBigInteger('prioritygroup_id')->nullable();
            $table->foreign('prioritygroup_id')->references('id')->on('priority_groups');
            $table->string('gender')->nullable();
            $table->string('zip_code')->default('00000000');
            $table->string('public_place')->nullable();
            $table->string('place_number')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->default('Amapá')->nullable();
            $table->string('city')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->tinyInteger('vaccinated')->default(0);
            $table->tinyInteger('bedridden')->default(0);
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
