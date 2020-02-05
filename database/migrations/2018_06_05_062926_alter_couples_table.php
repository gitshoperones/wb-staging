<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCouplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('couples', function (Blueprint $table) {
            $table->dropColumn([
                'contact_email', 'contact_phone_number', 'wedding_venue_id',
                'ceremony_venue_id', 'reception_venue_id', 'total_guest_invited',
                'total_guest_confirmed', 'wedding_date',
            ]);
        });
    }
}
