<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminEmailNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_email_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notification_event_id')->unsigned();
            $table->foreign('notification_event_id')
                ->references('id')
                ->on('notification_events')
                ->onDelete('cascade');
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();
            $table->string('is_read')->boolean()->default(false);
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
        Schema::dropIfExists('admin_email_notifications');
    }
}
