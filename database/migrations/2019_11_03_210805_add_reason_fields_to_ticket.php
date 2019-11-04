<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReasonFieldsToTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            $table->unsignedBigInteger('reason_by')->nullable()->after('completed_at');
            $table->text('reason')->nullable()->after('completed_at');

            $table->foreign('parent_id')->references('id')->on('tickets');
            $table->foreign('reason_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_parent_id_foreign');
            $table->dropForeign('tickets_reason_by_foreign');

            $table->dropColumn(['parent_id', 'reason', 'reason_by']);
        });
    }
}
