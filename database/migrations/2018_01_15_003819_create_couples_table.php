<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('couples', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userA_id')->unsigned();
            $table->foreign('userA_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->integer('userB_id')->nullable();
            $table->string('title')->nullable();
            $table->text('desc')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone_number')->nullable();
            $table->integer('wedding_venue_id')->nullable();
            $table->integer('ceremony_venue_id')->nullable();
            $table->integer('reception_venue_id')->nullable();
            $table->tinyInteger('total_guest_invited')->nullable();
            $table->tinyInteger('total_guest_confirmed')->nullable();
            $table->date('wedding_date')->nullable();
            $table->string('profile_avatar')->nullable();
            $table->string('profile_cover')->nullable();
            $table->tinyInteger('onboarding')->default(0);
            $table->timestamps();

            $table->index(['id', 'userA_id', 'userB_id', 'title', 'contact_email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('couples');
    }
}
