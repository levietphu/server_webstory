<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTheloaiTruyensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theloai_truyens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_theloai')->nullable();
            $table->unsignedBigInteger('id_truyen')->nullable();
            $table->timestamps();
            $table->foreign('id_truyen')->references('id')->on('truyens')->onDelete('cascade');
            $table->foreign('id_theloai')->references('id')->on('theloais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('theloai_truyens');
    }
}
