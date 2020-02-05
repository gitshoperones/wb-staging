<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('total', 5, 2)->after('job_quote_id');
            $table->decimal('balance', 5, 2)->after('job_quote_id');
            $table->date('next_payment_date')->nullable()->after('job_quote_id');
        });
    }
}
