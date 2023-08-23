<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdToWithdrawMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraw_money', function (Blueprint $table) {
            $table->unsignedBigInteger("id_affiliatedbank");
            $table->foreign('id_affiliatedbank')->references('id')->on('affiliated_banks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraw_money', function (Blueprint $table) {
            //
        });
    }
}
