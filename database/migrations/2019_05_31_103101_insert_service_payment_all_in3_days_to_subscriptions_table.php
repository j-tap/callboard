<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Payment\Subscription;
use Carbon\Carbon;

class InsertServicePaymentAllIn3DaysToSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {

            Subscription::where('parent_id' , '<>', null)->update(['parent_id' => null]);
            Subscription::create([  
                'name' => 'Pro аккаунт в подарок на 3 дня', 
                'slug' => 'payment_all_in_3_days', 
                'description' => 'Оплата про-аккаунта, включает в себя все пакеты. Тариф - все включено на 3 дня',
                'started_at' => Carbon::now(),
                'duration_days' => 3,
                'status' => Subscription::SUBSCRIPTION_STATUS_ACTIVE,
                'cost' => 0,
                'parent_id' =>  Subscription::getIdOfServiceFromSlug(Subscription::SUBSCRIPTION_PAYMENT_ALL_IN)
            ]);
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
            //
        });
    }
}
