<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_data', function (Blueprint $table) {
            $table->id();
            $table->integer('delivery_id')->nullable();
           
            $table->double('cash_record',20,2)->default(0);
            $table->double('credit_given',20,2)->default(0);
            $table->double('credit_record',20,2)->default(0);
            $table->double('balance_credit',20,2)->default(0);
            $table->double('cancelled',20,2)->default(0);
            $table->double('shortage',20,2)->default(0);
            $table->double('damage',20,2)->default(0);
            $table->double('expiry',20,2)->default(0);
            $table->double('upi_record',20,2)->default(0);
            $table->double('cheque_record',20,2)->default(0);
            $table->double('cheque_cleared',20,2)->default(0);
            $table->double('cheque_balance',20,2)->default(0);
            $table->double('total_collection',20,2)->default(0);
            $table->double('balance_collection',20,2)->default(0);
            $table->double('discount',20,2)->default(0);
            $table->double('cgst',20,2)->default(0);
            $table->double('sgst',20,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_data');
    }
}
