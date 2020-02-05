<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileJobQuoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_job_quote', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_quote_id')->unsigned();
            $table->foreign('job_quote_id')
                ->references('id')
                ->on('job_quotes')
                ->onDelete('cascade');
            $table->integer('file_id')->unsigned();
            $table->foreign('file_id')
                ->references('id')
                ->on('files')
                ->onDelete('cascade');
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
        Schema::dropIfExists('file_job_quote');
    }
}
