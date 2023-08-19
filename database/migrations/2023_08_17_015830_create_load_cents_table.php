<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadCentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('load_cents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_bankinfo');
            $table->integer("value");
            $table->integer("bonus")->nullable();
            $table->foreign('id_bankinfo')->references('id')->on('bank_infos')->onDelete('cascade');
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
        Schema::dropIfExists('load_cents');
    }
}
