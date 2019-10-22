<?php

use App\Enums\FancyNotificationPeriod;
use App\Enums\PBXType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFancySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fancy_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fancy_number_id');
            $table->boolean('always_open')->default(false);
            $table->boolean('enable_downtime_hours')->default(false);
            $table->json('business_hours')->nullable();
            $table->json('downtime_hours')->nullable();
            $table->json('extensions')->nullable();
            $table->string('email_notification')->nullable();
            $table->string('period_notification')->default(FancyNotificationPeriod::DAILY);
            $table->string('pbx_type')->default(PBXType::PREDEFINED);
            $table->unsignedBigInteger('business_message_id')->nullable();
            $table->unsignedBigInteger('downtime_message_id')->nullable();
            $table->unsignedBigInteger('onhold_message_id')->nullable();
            $table->text('business_custom_message')->nullable();
            $table->text('downtime_custom_message')->nullable();
            $table->text('onhold_custom_message')->nullable();
            $table->timestamps();

            $table->foreign('fancy_number_id')->references('id')->on('fancy_numbers');
            $table->foreign('business_message_id')->references('id')->on('pbx_messages');
            $table->foreign('downtime_message_id')->references('id')->on('pbx_messages');
            $table->foreign('onhold_message_id')->references('id')->on('pbx_messages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fancy_settings');
    }
}
