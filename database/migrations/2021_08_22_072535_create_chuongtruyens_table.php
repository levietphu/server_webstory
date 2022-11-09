<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChuongtruyensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chuongtruyens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_truyen');
            $table->string('name_chapter',255);
            $table->string('chapter_number',255);
            $table->string('slug',255);
            $table->text('content');
            $table->integer('coin')->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('chuongtruyens');
    }
}
