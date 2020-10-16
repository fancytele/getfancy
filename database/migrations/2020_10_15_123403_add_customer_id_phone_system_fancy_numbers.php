<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerIdPhoneSystemFancyNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fancy_numbers', function (Blueprint $table) {
            $table->unsignedInteger('customer_id_phone_system')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fancy_numbers', function (Blueprint $table) {
            $table->dropColumn('customer_id_phone_system');
        });
    }
}
