<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserstampToFancyNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fancy_numbers', function (Blueprint $table) {
            $table->bigInteger('deleted_by')->nullable()->after('did_status');
            $table->bigInteger('updated_by')->nullable()->after('did_status');
            $table->bigInteger('created_by')->nullable()->after('did_status');
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
            $table->dropColumn(['created_by', 'updated_by', 'deleted_by']);
        });
    }
}
