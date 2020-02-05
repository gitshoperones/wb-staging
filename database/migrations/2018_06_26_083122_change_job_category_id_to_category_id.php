<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeJobCategoryIdToCategoryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->dropColumn('job_category_id');
            $table->integer('category_id')->nullable()->unsigned()->after('user_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails('tablename');
            if ($doctrineTable->hasIndex('job_posts_id_job_category_id_event_id_index')) {
                $table->dropIndex('job_posts_id_job_category_id_event_id_index');
            }
            $table->index(['id', 'category_id', 'event_id']);
        });
    }
}
