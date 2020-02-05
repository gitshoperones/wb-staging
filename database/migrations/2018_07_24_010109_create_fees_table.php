<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gateway_fee_id');
            $table->string('name');
            $table->string('fee_type_id');
            $table->string('amount');
            $table->string('cap')->nullable();
            $table->string('min')->nullable();
            $table->tinyInteger('default')->default(0);
            $table->tinyInteger('single_use')->default(0);
            $table->date('exp_date')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('fees');
    }
}
