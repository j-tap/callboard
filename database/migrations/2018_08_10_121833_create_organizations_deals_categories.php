<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsDealsCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations_deals_categories', function (Blueprint $table) {
            $table->integer('deal_id')->unsigned()->index();
            $table->integer('category_id')->unsigned()->index();

            $table->foreign('deal_id')->references('id')->on('organizations_deals')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations_deals_categories');
    }
}
