<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsDealsQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations_deals_questions', function (Blueprint $table) {
            $table->integer('deal_id')->unsigned()->index();
            $table->integer('question_id')->unsigned()->index();

            $table->foreign('deal_id')->references('id')->on('organizations_deals')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('deals_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations_deals_questions');
    }
}
