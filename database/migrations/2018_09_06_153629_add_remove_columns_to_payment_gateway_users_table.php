<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemoveColumnsToPaymentGatewayUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_gateway_users', function (Blueprint $table) {
            $table->string('gateway_name')->nullable()->after('gateway_account_id');
            $table->string('gateway_bank_acct_id')->nullable()->after('gateway_account_id');
            $table->string('gateway_company_id')->nullable()->after('gateway_account_id');
            $table->renameColumn('gateway_account_id', 'gateway_user_id');
            $table->dropColumn('gateway_account_details');
        });
    }
}
