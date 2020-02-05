<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHolderTypeColumnToVendorPaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_payment_settings', function (Blueprint $table) {
            $table->string('holder_type')->after('accnt_type');
            $table->string('gateway_bank_acct_id')->after('vendor_id');
        });
    }
}
