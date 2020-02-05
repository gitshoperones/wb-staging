<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_affiliates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_vendor_id')->unsigned();
            $table->foreign('parent_vendor_id')
                ->references('id')
                ->on('vendors')
                ->onDelete('cascade');
            $table->integer('child_vendor_id')->unsigned();
            $table->foreign('child_vendor_id')
                ->references('id')
                ->on('vendors')
                ->onDelete('cascade');
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
        Schema::dropIfExists('vendor_affiliates');
    }
}
