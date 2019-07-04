<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

use \App\Models\Org\Organization;

class UpdateOrgStatusRowsDefaultToOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            DB::statement("ALTER TABLE organizations MODIFY COLUMN org_status ENUM ('" . 
                        Organization::ORG_STATUS_APPROVE . "','" . 
                        Organization::ORG_STATUS_ARCHIVE . "','" . 
                        Organization::ORG_STATUS_REGISTRED . "') DEFAULT '" . Organization::ORG_STATUS_APPROVE . "';");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            DB::statement("ALTER TABLE organizations MODIFY COLUMN org_status ENUM ('" . 
                        Organization::ORG_STATUS_APPROVE . "','" . 
                        Organization::ORG_STATUS_ARCHIVE . "','" . 
                        Organization::ORG_STATUS_REGISTRED . "') DEFAULT '" . Organization::ORG_STATUS_REGISTRED . "';");
        });
    }
}
