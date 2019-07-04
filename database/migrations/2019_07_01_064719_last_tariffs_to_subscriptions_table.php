<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Payment\Subscription;

class LastTariffsToSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("SET foreign_key_checks=0");
        Artisan::call('db:seed', array('--class' => 'LastSubscriptionSeeder'));
        DB::statement("SET foreign_key_checks=1");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {

        });
    }
}
