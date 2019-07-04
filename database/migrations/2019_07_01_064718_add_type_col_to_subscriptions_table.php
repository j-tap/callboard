<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Payment\Subscription;

class AddTypeColToSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->enum('type', [Subscription::SUBSCRIPTION_TYPE_TARIFF, Subscription::SUBSCRIPTION_TYPE_SERVICE])->default(Subscription::SUBSCRIPTION_TYPE_TARIFF)->nullable()->after('cost');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            Schema::dropIfExists('type');
        });
    }
}
