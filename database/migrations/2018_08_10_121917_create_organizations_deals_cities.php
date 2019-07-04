<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsDealsCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations_deals_cities', function (Blueprint $table) {
            $table->integer('deal_id')->unsigned()->index();
            $table->integer('city_id')->unsigned()->index();

            $table->foreign('deal_id')->references('id')->on('organizations_deals')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations_deals_cities');
    }
}
