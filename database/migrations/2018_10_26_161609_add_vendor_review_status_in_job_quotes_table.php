<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVendorReviewStatusInJobQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_quotes', function (Blueprint $table) {
            $table->tinyInteger('vendor_review_status')->after('locked')->default(0);
        });
    }
}
