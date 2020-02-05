<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_quotes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->integer('job_post_id')->unsigned();
            $table->foreign('job_post_id')
                ->references('id')
                ->on('job_posts')
                ->onDelete('cascade');
            $table->text('message')->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->json('specs')->nullable();
            $table->json('confirmed_dates')->nullable();
            $table->date('duration')->nullable();
            $table->integer('tc_file_id')->nullable();
            $table->tinyInteger('apply_gst')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('locked')->nullable()->default(0);
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
        Schema::dropIfExists('job_quotes');
    }
}
