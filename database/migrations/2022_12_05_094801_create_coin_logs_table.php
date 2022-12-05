<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_code',25);
            $table->string('content');
            $table->string('note')->nullable();
            $table->bigInteger('coin_number');
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('coin_logs');
    }
}
