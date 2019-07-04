<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDialogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dialogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seller_id')->unsigned()->index();
            $table->integer('buyer_id')->unsigned()->index();

            $table->foreign('seller_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dialogs');
    }
}
