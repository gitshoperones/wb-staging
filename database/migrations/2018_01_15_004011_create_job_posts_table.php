<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->integer('job_category_id')->nullable();
            $table->integer('event_id')->nullable();
            $table->integer('job_time_requirement_id')->nullable();
            $table->date('event_date')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->json('shipping_address')->nullable();
            $table->string('required_address')->nullable();
            $table->string('completion_date')->nullable();
            $table->integer('number_of_guests')->nullable();
            $table->text('specifics')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->index(['id', 'job_category_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_posts');
    }
}
