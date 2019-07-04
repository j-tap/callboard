<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Payment\Subscription;

class CreateUserSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('deal_id')->unsigned()->nullable();
            $table->string('description', 1000)->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->integer('duration_days')->default(0)->comment('продолжительность акции в днях, выводится для юзера в сообщении, приорететно над subscriptions.duration_days');
            $table->enum('status', [
                    Subscription::SUBSCRIPTION_STATUS_ACTIVE, 
                    Subscription::SUBSCRIPTION_STATUS_FINISHED, 
                    Subscription::SUBSCRIPTION_STATUS_PAUSE, 
                ])->default( Subscription::SUBSCRIPTION_STATUS_PAUSE)->index();
            $table->integer('cost')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->foreign('deal_id')->references('id')->on('organizations_deals')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_subscriptions');
    }
}
