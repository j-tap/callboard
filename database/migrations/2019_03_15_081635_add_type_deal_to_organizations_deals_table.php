<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Org\OrganizationDeal;

class AddTypeDealToOrganizationsDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations_deals', function (Blueprint $table) {
            $table->enum('type_deal', [OrganizationDeal::DEAL_TYPE_SELL, OrganizationDeal::DEAL_TYPE_BUY])->default(OrganizationDeal::DEAL_TYPE_SELL)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations_deals', function (Blueprint $table) {
            $table->dropColumn('type_deal');
        });
    }
}
