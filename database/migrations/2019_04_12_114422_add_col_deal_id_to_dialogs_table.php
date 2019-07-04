<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColDealIdToDialogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dialogs', function (Blueprint $table) {
            $table->integer('deal_id')->after('buyer_id')->unsigned()->index();

            $table->foreign('deal_id')->references('id')->on('organizations_deals')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dialogs', function (Blueprint $table) {
            $table->dropColumn('deal_id');
        });
    }
}
