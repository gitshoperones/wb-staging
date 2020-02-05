<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobPostWebsiteRequirementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_post_website_requirement', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_post_id')->unsigned();
            $table->foreign('job_post_id')
                ->references('id')
                ->on('job_posts')
                ->onDelete('cascade');
            $table->integer('website_requirement_id')->unsigned();
            $table->foreign('website_requirement_id')
                ->references('id')
                ->on('website_requirements')
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
        Schema::dropIfExists('job_post_website_requirement');
    }
}
