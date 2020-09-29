<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserAddIsTwoFactorAuthentication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_twoFactorAuthentication')->default(true);
            $table->unsignedBigInteger('authorized_user_id_1')->nullable();
            $table->unsignedBigInteger('authorized_user_id_2')->nullable();
            $table->unsignedBigInteger('authorized_user_id_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_twoFactorAuthentication');
            $table->dropColumn('authorised_user_id_1');
            $table->dropColumn('authorised_user_id_2');
            $table->dropColumn('authorised_user_id_3');
        });
    }
}
