<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobQuoteMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_quote_milestones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_quote_id')->unsigned();
            $table->foreign('job_quote_id')
                ->references('id')
                ->on('job_quotes')
                ->onDelete('cascade');
            // $table->decimal('percent', 5, 2)->nullable();
            $table->decimal('percent', 20, 17)->nullable();
            $table->date('due_date')->nullable();
            $table->text('desc')->nullable();
            $table->tinyInteger('paid')->default(0);
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
        Schema::dropIfExists('job_quote_milestones');
    }
}
