<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLanguagesToFancySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fancy_settings', function (Blueprint $table) {
            $table->string('languages')->nullable()->after('downtime_hours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fancy_settings', function (Blueprint $table) {
            $table->dropColumn('languages');
        });
    }
}
