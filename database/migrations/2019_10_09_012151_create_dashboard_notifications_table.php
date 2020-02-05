<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDashboardNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notification_event_id')->unsigned();
            $table->foreign('notification_event_id')
                ->references('id')
                ->on('notification_events')
                ->onDelete('cascade');
            $table->string('frequency')->nullable();
            $table->string('subject')->nullable();
            $table->string('body')->nullable();
            $table->string('button')->nullable();
            $table->string('button_link')->nullable();
            $table->string('button2')->nullable();
            $table->string('button_link2')->nullable();
            $table->string('recipient')->nullable();
            $table->longText('tokens_subject')->nullable();
            $table->longText('tokens_body')->nullable();
            $table->string('type');
            $table->boolean('status')->default(1);
            
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
        Schema::dropIfExists('dashboard_notifications');
    }
}
