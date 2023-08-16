<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_marks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_chuong');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_truyen');
            $table->boolean("bought")->default(0);
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_chuong')->references('id')->on('chuongtruyens')->onDelete('cascade');
            $table->foreign('id_truyen')->references('id')->on('truyens')->onDelete('cascade');
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
        Schema::dropIfExists('book_marks');
    }
}
