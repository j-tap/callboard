<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsDeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations_deals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->string('name');
            $table->text('description');
            $table->string('question', 1024)->nullable();

            $table->boolean('pay_type_cash')->default(0)->index();
            $table->boolean('pay_type_noncash')->default(0)->index();

            $table->integer('budget_from')->default(0)->index();
            $table->integer('budget_to')->default(0)->index();

            $table->boolean('fast_deal')->default(0)->index();
            $table->boolean('favorite_only')->default(0)->index();

            $table->date('deadline_deal')->index();
            $table->date('deadline_service')->index();

            $table->softDeletes();
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
        Schema::dropIfExists('organizations_deals');
    }
}
