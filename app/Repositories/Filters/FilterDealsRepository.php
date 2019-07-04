<?php
/**
 * Created by black40x@yandex.ru
 * Date: 26/11/2018
 */

namespace App\Repositories\Filters;


use App\Models\Org\Organization;
use App\Models\Org\OrganizationDeal;
use App\Models\User;
use App\Models\Payment\Subscription;
use App\Models\Payment\UserSubscription;
use App\Repositories\CategoryRepository;
use App\Http\Controllers\Client\Api\v1\PaymentServicesController;


use Auth;

class FilterDealsRepository
{

    public static function getUserDeals(User $user, $categories = false, $countries = false, $regions = false, $cities = false, 
                                        $finish = null, $typeDeal = null , $subtypeDeal = null, $status = null, $payment_status = null)
    {
        // if ($user->organization->org_type == Organization::ORG_TYPE_BUYER) {
        //     return $user->organization->deals()->with(['organization', 'questions', 'members', 'categories', 'cities', 'user']);
        // } else {
        //     return OrganizationDeal::with(['organization', 'questions', 'members', 'categories', 'cities', 'user'])
        //             ->leftJoin('organizations_deals_members', function ($join) {
        //                 $join->on('organizations_deals.id', '=', 'organizations_deals_members.deal_id');
        //             })
        //             ->where('organizations_deals_members.organization_id', $user->organization->id);
        // }

        $query = $user->organization->deals()->select(
            'organizations_deals.*'
        )->groupBy('organizations_deals.id');

        $query->leftJoin('organizations_deals_cities', function ($join) {
            $join->on('organizations_deals_cities.deal_id', '=', 'organizations_deals.id');
        });

        $query->leftJoin('cities', function ($join) {
            $join->on('organizations_deals_cities.city_id', '=', 'cities.id');
        });

        $query->leftJoin('regions', function ($join) {
            $join->on('cities.region_id', '=', 'regions.id');
        });

        $query->leftJoin('countries', function ($join) {
            $join->on('regions.country_id', '=', 'countries.id');
        });

        $query->leftJoin('organizations_deals_categories', function ($join) {
            $join->on('organizations_deals_categories.deal_id', '=', 'organizations_deals.id');
        });

        $query->leftJoin('images_deals', function ($join) {
            $join->on('images_deals.deal_id', '=', 'organizations_deals.id');
        });

        if ($finish !== null ){
            if ($finish) {
                $query->where('organizations_deals.finish', 1);
            } else {
                $query->where('organizations_deals.finish', 0);
            }
        }
        else{
            $query->where('organizations_deals.finish', 0);
        }

        if ($status !== null ){
            $query->where('organizations_deals.status', $status);
        }
        else{
            $query->where('organizations_deals.status', '=' , OrganizationDeal::DEAL_STATUS_APPROVE);
        }

        if ($payment_status !== null ){
            $query->where('organizations_deals.payment_status', $payment_status);
        }
        else{
            $query->where('organizations_deals.payment_status', '<>' , OrganizationDeal::DEAL_STATUS_PAYMENT_NOT_PAID);
        }

        if (!empty($cities)) $query->whereIn('organizations_deals_cities.city_id', $cities);
        if (!empty($regions)) $query->whereIn('region_id', $regions);
        if (!empty($countries)) $query->whereIn('country_id', $countries);
        if (!empty($categories)) $query->whereIn('organizations_deals_categories.category_id', CategoryRepository::getIncludedTree($categories));
        
        if ($typeDeal !== null) $query->where('organizations_deals.type_deal', $typeDeal); 
        if ($subtypeDeal !== null) $query->where('organizations_deals.subtype_deal', $subtypeDeal); 

        $query->orderBy('organizations_deals.created_at', 'desc');

        return $query->with(['organization', 'members', 'categories', 'cities', 'user' , 'imagesDeals']);
    }

    public static function filter($categories = false, $countries = false, $regions = false, $cities = false,
                                  $fastDeal = null, $payTypeCash = null, $payTypeNonCash = null, $finish = null, $typeDeal = null ,
                                  $city = false, $dateCreateDeal = null , $dateDeadlineDeal = null, 
                                  $budgetFrom = false, $budgetTo = false, $withPhoto = false, $inDealName = false, $subtypeDeal = null , 
                                  $status = null, $userId = null,  $payment_status = null)
    {
        // // ============================== Платность услуги показа контактов в объявлении о куплю (вопле) ========================================
        // $user = Auth::guard('api')->user();
        // $isLogined = ($user) ? true : false;

        // if($isLogined){
        //     //$paymentService = new PaymentServicesController();
        //     $isProAccount = $user->isProAccount();
        //    // $paymentInfo = $paymentService->paymentServiceIsPossible(null, Subscription::SUBSCRIPTION_PAYMENT_ONCE_DEAL_BUY_GET_CONTACTS , true);
        //     //dd($isProAccount);
        //     $idsDealsBuyContacts = $user->idsDealsBuyContacts(); // id объявлений с проплаченными контактами
        //     dd($idsDealsBuyContacts);
        // }
        // // ==============================END  Платность услуги показа контактов в объявлении о куплю (вопле) =====================================

        $query = OrganizationDeal::query()->select(
            'organizations_deals.*'
        )->groupBy('organizations_deals.id');

        $query->leftJoin('organizations_deals_cities', function ($join) {
            $join->on('organizations_deals_cities.deal_id', '=', 'organizations_deals.id');
        });

        $query->leftJoin('cities', function ($join) {
            $join->on('organizations_deals_cities.city_id', '=', 'cities.id');
        });

        $query->leftJoin('regions', function ($join) {
            $join->on('cities.region_id', '=', 'regions.id');
        });

        $query->leftJoin('countries', function ($join) {
            $join->on('regions.country_id', '=', 'countries.id');
        });

        $query->leftJoin('organizations_deals_categories', function ($join) {
            $join->on('organizations_deals_categories.deal_id', '=', 'organizations_deals.id');
        });

        $query->leftJoin('images_deals', function ($join) {
            $join->on('images_deals.deal_id', '=', 'organizations_deals.id');
        });

        $query->leftJoin('user_selected_deals', function ($join) {
            $join->on('user_selected_deals.deal_id', '=', 'organizations_deals.id');
        });
        
        if ($finish !== null ){
            if ($finish) {
                $query->where('organizations_deals.finish', 1);
            } else {
                $query->where('organizations_deals.finish', 0);
            }
        }
        else{
            $query->where('organizations_deals.finish', 0);
        }

        if ($status !== null ){
            $query->where('organizations_deals.status', '=', $status);
        }
        else{
            $query->where('organizations_deals.status', '=' , OrganizationDeal::DEAL_STATUS_APPROVE);
        }

        if ($payment_status !== null ){
            $query->where('organizations_deals.payment_status', $payment_status);
        }
        else{
            $query->where('organizations_deals.payment_status', '<>' , OrganizationDeal::DEAL_STATUS_PAYMENT_NOT_PAID);
        }

        if ($userId !== null ){
            $query->where('organizations_deals.user_id', '=', $userId);
        }


        if (!empty($cities)) $query->whereIn('organizations_deals_cities.city_id', $cities);
        if (!empty($regions)) $query->whereIn('region_id', $regions);
        if (!empty($countries)) $query->whereIn('country_id', $countries);
        if (!empty($categories)) $query->whereIn('organizations_deals_categories.category_id', CategoryRepository::getIncludedTree($categories));

        // if (isset($fastDeal)) $query->where('organizations_deals.fast_deal', $fastDeal);  //todo удалить после чистки
        // if (isset($payTypeCash)) $query->where('organizations_deals.pay_type_cash', $payTypeCash); //todo удалить после чистки
        // if (isset($payTypeNonCash)) $query->where('organizations_deals.pay_type_noncash', $payTypeNonCash);   //todo удалить после чистки

        if (!empty($typeDeal)) $query->where('organizations_deals.type_deal', $typeDeal);    
        if (!empty($subtypeDeal)) $query->where('organizations_deals.subtype_deal', $subtypeDeal);    

        if (!empty($city)) $query->where('organizations_deals_cities.city_id', $city);  
        if (!empty($inDealName)) $query->where('organizations_deals.name', 'like', '%' . $inDealName . '%');  


        if (!empty($budgetFrom) and !empty($budgetTo) and ($budgetFrom >= 0 and  $budgetFrom <= $budgetTo )) {
            $query->whereBetween('organizations_deals.budget_to', [$budgetFrom, $budgetTo]);  
        }


        if (empty($dateCreateDeal)) {
            $query->orderBy('organizations_deals.created_at', 'desc');
        }
        else{
            $query->orderBy('organizations_deals.created_at', $dateCreateDeal);
        }
        if (empty($dateDeadlineDeal)) {
            $query->orderBy('organizations_deals.deadline_deal', 'desc');
        }
        else{
            $query->orderBy('organizations_deals.deadline_deal', $dateDeadlineDeal);
        }


        if (!empty($withPhoto) and ((int) $withPhoto === 1 or  $withPhoto === true)) {
            $query->has('imagesDeals');
            return $query->with(['organization',  'categories', 'cities', 'imagesDeals', 'user', 'favouritedFromUsers' ]);
        }

  //      dd($query->with(['organization',  'categories', 'cities', 'user' , 'imagesDeals']));
        return $query->with(['organization',  'categories', 'cities', 'user' , 'imagesDeals', 'favouritedFromUsers']);
    }

}