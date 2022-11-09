<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToIdTruyenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_chuongtruyens', function (Blueprint $table) {
           $table->unsignedBigInteger('id_truyen');
           $table->foreign('id_truyen')->references('id')->on('truyens')->onDelete('cascade');
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
