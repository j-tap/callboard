<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Org\OrganizationDeal;

class AddStatusColToOrganizationsDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations_deals', function (Blueprint $table) {
            $table->enum('status', [OrganizationDeal::DEAL_STATUS_MODERATION,
                                    OrganizationDeal::DEAL_STATUS_APPROVE,  
                                    OrganizationDeal::DEAL_STATUS_ARCHIVE,   
                                    OrganizationDeal::DEAL_STATUS_BANNED])->after('count_views')->default(OrganizationDeal::DEAL_STATUS_MODERATION)->nullable()->index();
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
            Schema::dropIfExists('status');
        });
    }
}
