<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnsVendorPaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_payment_settings', function (Blueprint $table) {
            $table->dropColumn(['legal_name', 'street', 'city', 'state', 'country', 'postcode']);
        });
    }
}
