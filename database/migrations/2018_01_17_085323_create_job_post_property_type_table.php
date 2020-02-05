<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobPostPropertyTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_post_property_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_post_id')->unsigned();
            $table->foreign('job_post_id')
                ->references('id')
                ->on('job_posts')
                ->onDelete('cascade');
            $table->integer('property_type_id')->unsigned();
            $table->foreign('property_type_id')
                ->references('id')
                ->on('property_types')
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
        Schema::dropIfExists('job_post_property_type');
    }
}
