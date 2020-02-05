<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->default(null);
            $table->unsignedInteger('vendor_id');
            $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors')
                ->onDelete('cascade');
            $table->string('event_date')->default(null)->nullable(); // string since it will be just month and year
            $table->string('event_type')->default(null)->nullable();
            $table->string('reviewer_name')->default(null)->nullable();
            $table->string('reviewer_email')->default(null)->nullable();
            $table->text('message')->default(null)->nullable();
            $table->decimal('rating', 10, 2)->default(0);
            $table->json('rating_breakdown')->default(null);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('vendor_reviews');
    }
}
