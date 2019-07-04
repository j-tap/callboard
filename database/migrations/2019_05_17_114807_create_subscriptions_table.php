<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Payment\Subscription;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('description', 1000)->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->integer('duration_days')->default(0)->comment('продолжительность акции в днях, выводится для юзера в сообщении');
            $table->enum('status', [
                    Subscription::SUBSCRIPTION_STATUS_ACTIVE, 
                    Subscription::SUBSCRIPTION_STATUS_FINISHED, 
                    Subscription::SUBSCRIPTION_STATUS_PAUSE, 
                ])->default( Subscription::SUBSCRIPTION_STATUS_PAUSE)->index();
            $table->integer('cost')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}