<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Org\OrganizationDeal;

class AddSubTypeDealToOrganizationsDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations_deals', function (Blueprint $table) {
            $table->enum('subtype_deal', [  OrganizationDeal::DEAL_SUBTYPE_NEW, 
                                            OrganizationDeal::DEAL_SUBTYPE_USED, 
                                            OrganizationDeal::DEAL_SUBTYPE_NA])->default(OrganizationDeal::DEAL_SUBTYPE_NA)->index();
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
            $table->dropColumn('subtype_deal');
        });
    }
}

