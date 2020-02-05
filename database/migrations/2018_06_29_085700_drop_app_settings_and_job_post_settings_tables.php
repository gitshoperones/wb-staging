<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAppSettingsAndJobPostSettingsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('app_settings');
        Schema::dropIfExists('job_post_settings');
        Schema::dropIfExists('user_settings');
    }
}
