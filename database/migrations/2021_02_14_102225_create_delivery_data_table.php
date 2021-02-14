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
           
            $table->double('cash_record',6.2)->default(0);
            $table->double('credit_given',6,2)->default(0);
            $table->double('credit_record',6,2)->default(0);
            $table->double('balance_credit',6,2)->default(0);
            $table->double('cancelled',6,2)->default(0);
            $table->double('shortage',6,2)->default(0);
            $table->double('damage',6,2)->default(0);
            $table->double('expiry',6,2)->default(0);
            $table->double('upi_record',6,2)->default(0);
            $table->double('cheque_record',6,2)->default(0);
            $table->double('cheque_cleared',6,2)->default(0);
            $table->double('cheque_balance',6,2)->default(0);
            $table->double('total_collection',6,2)->default(0);
            $table->double('balance_collection',6,2)->default(0);


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
