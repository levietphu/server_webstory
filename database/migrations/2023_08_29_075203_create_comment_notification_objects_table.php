<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentNotificationObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_notification_objects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_noti_object');
            $table->unsignedBigInteger('id_comment');
            $table->foreign('id_noti_object')->references('id')->on('notification_objects')->onDelete('cascade');
            $table->foreign('id_comment')->references('id')->on('comments')->onDelete('cascade');
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
        Schema::dropIfExists('comment_notification_objects');
    }
}
