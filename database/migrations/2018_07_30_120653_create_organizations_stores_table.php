<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->unsigned()->index();
            $table->string('address');
            $table->string('geo_lat', 9)->nullable();
            $table->string('geo_lon', 9)->nullable();

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations_stores');
    }
}
