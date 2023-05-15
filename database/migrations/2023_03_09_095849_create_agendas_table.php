<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('room_id')->unsigned()->nullable();
            $table->bigInteger('suggestion_id')->unsigned()->nullable();
            $table->bigInteger('person_in_charge')->unsigned()->nullable();
            $table->string('title');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->text('location')->nullable();
            $table->text('contents');
            $table->text('attachment')->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('suggestion_id')->references('id')->on('suggestions');
            $table->foreign('person_in_charge')->references('id')->on('users');
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
        Schema::dropIfExists('agendas');
    }
}
