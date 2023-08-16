<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToCoinLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coin_logs', function (Blueprint $table) {
            $table->text("image")->nullable();
        });
         Schema::table('bank_infos', function (Blueprint $table) {
            $table->string("email")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coin_logs', function (Blueprint $table) {
            //
        });
    }
}
