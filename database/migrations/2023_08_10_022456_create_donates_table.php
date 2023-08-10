<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_donate');
            $table->unsignedBigInteger('id_truyen');
            $table->integer("coin_donate");
            $table->string("message")->nullable();
            $table->foreign('user_donate')->references('id')->on('users');
            $table->foreign('id_truyen')->references('id')->on('truyens');
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
        Schema::dropIfExists('donates');
    }
}
