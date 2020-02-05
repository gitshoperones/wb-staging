<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notification_event_id')->unsigned();
            $table->foreign('notification_event_id')
                ->references('id')
                ->on('notification_events')
                ->onDelete('cascade');
            $table->integer('email_template_id')->unsigned();
            $table->foreign('email_template_id')
                ->references('id')
                ->on('email_templates')
                ->onDelete('cascade');
            $table->string('frequency')->nullable();
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();
            $table->string('button')->nullable();
            $table->string('button_link')->nullable();
            $table->string('recipient')->nullable();
            $table->longText('tokens_subject')->nullable();
            $table->longText('tokens_body')->nullable();
            $table->string('type');
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
        Schema::dropIfExists('email_notifications');
    }
}
