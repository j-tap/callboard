<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Org\OrganizationDeal;

class AddPaymentStatusColToOrganizationsDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations_deals', function (Blueprint $table) {
            $table->enum('payment_status', [
                    OrganizationDeal::DEAL_STATUS_PAYMENT_PAID, 
                    OrganizationDeal::DEAL_STATUS_PAYMENT_NOT_PAID, 
                    OrganizationDeal::DEAL_STATUS_PAYMENT_FREE
                ]
            )->after('status')->default( OrganizationDeal::DEAL_STATUS_PAYMENT_FREE)->index();
        });

        $deals = OrganizationDeal::all();
        if($deals){
            foreach($deals as $deal){
                // если продажа - то оплачено
                if($deal->type_deal ===  OrganizationDeal::DEAL_TYPE_SELL){
                      $deal->payment_status = OrganizationDeal::DEAL_STATUS_PAYMENT_PAID;
                }
                else{
                      $deal->payment_status = OrganizationDeal::DEAL_STATUS_PAYMENT_FREE;
                }
              
                $deal->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations_deals', function (Blueprint $table) {
            Schema::dropIfExists('payment_status');
        });
    }
}
