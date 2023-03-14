<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispositions', function (Blueprint $table) {
            $table->id();
            // $table->integer('agenda_id')->unsigned();
            // $table->integer('user_id')->unsigned()->nullable();
            // $table->integer('department_id')->unsigned()->nullable();
            // $table->foreign('agenda_id')->references('id')->on('agendas');
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('department_id')->references('id')->on('departments');
            $table->foreignId('agenda_id')->constrained('agendas') ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users') ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained('departments') ->onUpdate('cascade')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->integer('is_all')->nullable();
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
        Schema::dropIfExists('dispositions');
    }
}
