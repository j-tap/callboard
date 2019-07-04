<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs_admin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method')->comment('Какой метод отработал');
            $table->longText('data')->comment('Входящие данные в формате json');
            $table->integer('user_id')->comment('Id админа который вызвал действие');
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
        Schema::dropIfExists('logs_admin');
    }
}

