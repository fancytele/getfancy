<?php

use App\Enums\DIDNumberType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enums\DIDOrderStatus;

class CreateFancyNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fancy_numbers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('type')->default(DIDNumberType::Fancy);
            $table->uuid('did_id');
            $table->uuid('did_purchase_id');
            $table->string('did_number');
            $table->string('did_reference');
            $table->string('did_status')->default(DIDOrderStatus::Pending);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fancy_numbers');
    }
}
