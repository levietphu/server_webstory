<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToTruyensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truyens', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tacgia')->nullable();
            $table->unsignedBigInteger('id_trans')->nullable();
            $table->foreign('id_tacgia')->references('id')->on('tacgias')->onDelete('cascade');
            $table->foreign('id_trans')->references('id')->on('translators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('truyens', function (Blueprint $table) {
            //
        });
    }
}
