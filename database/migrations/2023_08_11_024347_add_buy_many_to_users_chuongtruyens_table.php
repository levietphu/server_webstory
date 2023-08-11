<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuyManyToUsersChuongtruyensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_chuongtruyens', function (Blueprint $table) {
            $table->tinyInteger("buy_many")->default(0)->comment("0 là mua ít hoặc free","1 là mua nhiều");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_chuongtruyens', function (Blueprint $table) {
            //
        });
    }
}
