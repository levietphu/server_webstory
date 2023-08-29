<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonateNotificationObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donate_notification_objects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_noti_object');
            $table->unsignedBigInteger('id_donate');
            $table->foreign('id_noti_object')->references('id')->on('notification_objects')->onDelete('cascade');
            $table->foreign('id_donate')->references('id')->on('donates')->onDelete('cascade');
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
        Schema::dropIfExists('donate_notification_objects');
    }
}
