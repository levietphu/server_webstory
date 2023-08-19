<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name_bank");
            $table->string("owner");
            $table->bigInteger("stk")->nullable();
            $table->text("qr_code")->nullable();
            $table->text('image');
            $table->string('email')->nullable();
            $table->tinyInteger("type")->comment("0 là ngân hàng,1 là ví,2 là thẻ cào");
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
        Schema::dropIfExists('bank_infos');
    }
}
