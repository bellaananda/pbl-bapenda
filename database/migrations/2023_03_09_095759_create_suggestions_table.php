<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuggestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();
            // $table->integer('user_id')->unsigned();
            // $table->integer('department_id')->unsigned();
            // $table->integer('category_id')->unsigned();
            $table->foreignId('user_id')->constrained('users') ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments') ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories') ->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->text('contents');
            $table->string('person_in_charge');
            $table->text('location');
            $table->text('attachment')->nullable();
            $table->integer('status');
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('department_id')->references('id')->on('departments');
            // $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('suggestions');
    }
}
