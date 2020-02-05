<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('business_name')->nullable();
            $table->string('trading_name')->nullable();
            $table->text('desc')->nullable();
            $table->string('abn')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('website')->nullable();
            $table->string('profile_cover')->nullable();
            $table->integer('rank')->nullable();
            $table->string('profile_avatar')->nullable();
            $table->tinyInteger('onboarding')->default(0);
            $table->timestamps();

            $table->index(['id', 'user_id', 'business_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
