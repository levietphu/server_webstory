<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadCentNotificationObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('load_cent_notification_objects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_noti_object');
            $table->unsignedBigInteger('id_transition');
            $table->foreign('id_noti_object')->references('id')->on('notification_objects')->onDelete('cascade');
            $table->foreign('id_transition')->references('id')->on('transition_histories')->onDelete('cascade');
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
        Schema::dropIfExists('load_cent_notification_objects');
    }
}
