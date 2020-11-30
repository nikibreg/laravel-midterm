<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->mediumText('title');       
            $table->boolean('is_correct');       
            $table->bigInteger('question_id')->unsigned();       
            $table->foreign('question_id')
                        ->references('id')
                        ->on('questions')
                        ->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            Schema::dropIfExists('answers');
        });
    }
}
