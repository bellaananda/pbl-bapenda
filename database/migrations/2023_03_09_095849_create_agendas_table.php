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
            // $table->integer('department_id')->unsigned();
            // $table->integer('category_id')->unsigned();
            // $table->integer('suggestion_id')->unsigned()->nullable();
            $table->foreignId('department_id')->constrained('departments') ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories') ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('suggestion_id')->nullable()->constrained('suggestions') ->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->text('contents');
            $table->string('person_in_charge');
            $table->text('location');
            $table->text('attachment')->nullable();
            // $table->foreign('department_id')->references('id')->on('departments');
            // $table->foreign('category_id')->references('id')->on('categories');
            // $table->foreign('suggestion_id')->references('id')->on('suggestions');
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
