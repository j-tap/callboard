<?php

use Illuminate\Database\Seeder;
use \App\Models\Org\OrganizationDeal;
//use DB;


// использовать только для cейчас, потом не использовать
// запустить>  php artisan db:seed --class=SubTypeOrganizationsDealSeeder
class SubTypeOrganizationsDealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::update('update organizations_deals set subtype_deal = ? where type_deal = ?' , 
                [OrganizationDeal::DEAL_SUBTYPE_NEW, OrganizationDeal::DEAL_TYPE_SELL]);
    }
}
