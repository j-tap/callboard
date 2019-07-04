<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsNeedKpColToOrganizationsDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations_deals', function (Blueprint $table) {
            $table->boolean('is_need_kp')->default(false);
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
            $table->dropColumn('is_need_kp');
        });
    }
}
