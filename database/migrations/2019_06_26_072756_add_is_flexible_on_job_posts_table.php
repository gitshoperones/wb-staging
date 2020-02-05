<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsFlexibleOnJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->integer('vendor_id')->default(0)->nullable()->after('category_id');
            $table->tinyInteger('is_flexible')->default(0)->after('beauty_subcategories_id');
            $table->tinyInteger('is_invite')->default(0)->after('beauty_subcategories_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
            $table->dropColumn('is_flexible');
            $table->dropColumn('is_invite');
        });
    }
}
