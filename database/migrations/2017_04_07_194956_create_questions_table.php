<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned();
            $table->string('question_type')->default('text');
            $table->string('label');
            $table->text('description')->nullable();
            $table->text('options')->nullable();
            $table->boolean('required')->default(0);
            $table->timestamps();

            $table->foreign('survey_id')
                  ->references('id')
                  ->on('surveys')
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
        Schema::dropIfExists('questions');
    }
}
