<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResponseProcessedColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->boolean('processed')->default(0);
            $table->unsignedInteger('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->dropColumn('processed');
            $table->dropColumn('user_id');
        });
    }
}
