<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdBankinfoToTransitionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transition_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('id_bankinfo');
            $table->foreign('id_bankinfo')->references('id')->on('bank_infos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transition_histories', function (Blueprint $table) {
            //
        });
    }
}
