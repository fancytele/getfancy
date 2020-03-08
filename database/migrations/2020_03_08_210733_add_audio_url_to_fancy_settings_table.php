<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAudioUrlToFancySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fancy_settings', function (Blueprint $table) {
            $table->string('audio_url')->after('audio_type')->nullable();
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
            $table->dropColumn('audio_url');
        });
    }
}
