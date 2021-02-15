<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_logs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('row_number')->nullable();
            $table->string('delivery_note_number')->nullable();
            $table->string('beat_name')->nullable();
            $table->string('fail_reason')->nullable();

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
        Schema::dropIfExists('file_logs');
    }
}
