<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\DB;

class UpdateRowsDefaultToOrganizationsDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations_deals', function (Blueprint $table) {

            DB::statement("ALTER TABLE organizations_deals MODIFY COLUMN deadline_deal DATE NULL;");
            DB::statement("ALTER TABLE organizations_deals MODIFY COLUMN deadline_service DATE NULL;");
            DB::statement("ALTER TABLE organizations_deals MODIFY COLUMN `description` TEXT NULL;");
 
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
          
            DB::statement("ALTER TABLE organizations_deals MODIFY COLUMN deadline_deal DATE NOT NULL;");
            DB::statement("ALTER TABLE organizations_deals MODIFY COLUMN deadline_service DATE NOT NULL;");
            DB::statement("ALTER TABLE organizations_deals MODIFY COLUMN `description` TEXT NOT NULL;");

        });
    }
}
