<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations_deals_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deal_id')->unsigned()->index();
            $table->integer('organization_id')->unsigned()->index();
            $table->integer('question_id')->nullable()->index();
            $table->string('answer', 1024)->nullable();
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
        Schema::dropIfExists('organizations_deals_answers');
    }
}
