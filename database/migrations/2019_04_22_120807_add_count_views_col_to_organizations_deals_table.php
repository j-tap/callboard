<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountViewsColToOrganizationsDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations_deals', function (Blueprint $table) {     
            $table->integer('count_views')->unsigned()->after('description')->default(0)->comment('количество просмотров объявления');
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
            Schema::dropIfExists('count_views');
        });
    }
}
