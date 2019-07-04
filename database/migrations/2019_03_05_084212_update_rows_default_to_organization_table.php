<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Org\Organization;
use Illuminate\Support\Facades\DB;

class UpdateRowsDefaultToOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {

            DB::statement("ALTER TABLE organizations MODIFY COLUMN first_name VARCHAR (64) NULL;");
            DB::statement("ALTER TABLE organizations MODIFY COLUMN second_name VARCHAR (64) NULL;");
            DB::statement("ALTER TABLE organizations MODIFY COLUMN middle_name VARCHAR (64) NULL;");
            DB::statement("ALTER TABLE organizations MODIFY COLUMN phone VARCHAR (11) NULL;");
            DB::statement("ALTER TABLE organizations MODIFY COLUMN org_city_id INT UNSIGNED NOT NULL DEFAULT 108;");
            DB::statement("ALTER TABLE organizations MODIFY COLUMN org_name VARCHAR (191) NULL;");
            DB::statement("ALTER TABLE organizations MODIFY COLUMN org_inn VARCHAR (12) NULL;");

            DB::statement("ALTER TABLE organizations MODIFY COLUMN org_type ENUM('" . Organization::ORG_TYPE_BUYER . 
                                                                                 "','" . Organization::ORG_TYPE_SELLER .
                                                                                 "') NOT NULL DEFAULT '" . Organization::ORG_TYPE_BUYER . "';");
 
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
          
            DB::statement("ALTER TABLE organizations MODIFY COLUMN first_name VARCHAR (64) NOT NULL;");
            DB::statement("ALTER TABLE organizations MODIFY COLUMN second_name VARCHAR (64) NOT NULL;");
            DB::statement("ALTER TABLE organizations MODIFY COLUMN middle_name VARCHAR (64) NOT NULL;");
            DB::statement("ALTER TABLE organizations MODIFY COLUMN phone VARCHAR (11) NOT NULL;");
            DB::statement("ALTER TABLE organizations MODIFY COLUMN org_city_id INT UNSIGNED NOT NULL;");
            DB::statement("ALTER TABLE organizations MODIFY COLUMN org_name VARCHAR (191) NOT NULL;");
            DB::statement("ALTER TABLE organizations MODIFY COLUMN org_inn VARCHAR (12) NOT NULL;");

            DB::statement("ALTER TABLE organizations MODIFY COLUMN org_type ENUM('" . Organization::ORG_TYPE_BUYER . 
                                                                                 "','" . Organization::ORG_TYPE_SELLER .
                                                                                 "') NOT NULL;");

        });
    }
}
