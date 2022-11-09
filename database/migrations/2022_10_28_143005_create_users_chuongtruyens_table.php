<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersChuongtruyensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_chuongtruyens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_chuong');
            $table->unsignedBigInteger('id_user');
            $table->boolean("bought")->default(0);
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_chuong')->references('id')->on('chuongtruyens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_chuongtruyens');
    }
}
