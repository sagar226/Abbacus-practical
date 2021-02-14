<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->date('date')->format('d/m/Y');
            $table->string('delivery_note_number')->nullable();
            $table->string('beat_name')->nullable();
            $table->string('uid')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('net_receivable')->nullable();

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
        Schema::dropIfExists('deliveries');
    }
}
