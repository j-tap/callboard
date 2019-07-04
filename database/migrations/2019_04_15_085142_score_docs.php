<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScoreDocs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_docs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->comment('Id пользователя');
            $table->integer('organization_id')->comment('Id организации');
            $table->integer('unique_id')->comment('Id лк');
            $table->integer('number_score')->comment('номер счета');
            $table->string('dt_score')->comment('дата счета');
            $table->string('summ')->comment('Сумма к оплате');
            $table->integer('user_id')->comment('Кто выставил счет (id сотрудника)');
            $table->integer('status')->default(0)->comment('0 - не оплачен, 1-оплачен');
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
        Schema::dropIfExists('score_docs');
    }
}
