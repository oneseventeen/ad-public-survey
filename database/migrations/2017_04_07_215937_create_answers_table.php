<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_response_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->string('value')->nullable();
            $table->timestamps();

            $table->foreign('question_id')
                  ->references('id')
                  ->on('questions');

            $table->foreign('survey_response_id')
                  ->references('id')
                  ->on('survey_responses')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
