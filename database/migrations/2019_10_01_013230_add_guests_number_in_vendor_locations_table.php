<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGuestsNumberInVendorLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_locations', function (Blueprint $table) {
            $table->string('address')->nullable()->after('lng');
            $table->integer('adults')->nullable()->after('address');
            $table->integer('children')->nullable()->after('adults');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_locations', function (Blueprint $table) {
            //
        });
    }
}
