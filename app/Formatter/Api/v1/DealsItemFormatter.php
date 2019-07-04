<?php
/**
 * Created by black40x@yandex.ru
 * Date: 26/11/2018
 */

namespace App\Formatter\Api\v1;


use App\Formatter\Formatter;
use Illuminate\Pagination\Paginator;

use App\Models\Org\OrganizationDeal;
use App\Models\Payment\Subscription;
use App\Models\Payment\UserSubscription;

use Auth;

class DealsItemFormatter extends Formatter
{

    public static function format($item)
    {

        try{
            
            $user = Auth::guard('api')->user();
            $curUserId = $user ?  $user->id : null;


            // ============================== Платность услуги показа контактов в объявлении о куплю (вопле) ========================================
            $isLogined = ($user) ? true : false;

            if($isLogined){
                //$paymentService = new PaymentServicesController();
                $isProAccount = $user->isProAccount();
            // $paymentInfo = $paymentService->paymentServiceIsPossible(null, Subscription::SUBSCRIPTION_PAYMENT_ONCE_DEAL_BUY_GET_CONTACTS , true);
                //dd($isProAccount);
                $idsDealsBuyContacts = $user->idsDealsBuyContacts(); // id объявлений с проплаченными контактами
            //  dd($idsDealsBuyContacts);
            }
            // ==============================END  Платность услуги показа контактов в объявлении о куплю (вопле) =====================================

            $type_deal = $item->type_deal; // тип сделки
            //dd($item->imagesDeals);

            $arToCollect = [
                //   'cur_user' =>  $user ? $user->id : null,
                'id' => $item->id,
                'date_create' => $item->created_at,
                'date_update' => $item->updated_at,
            
                'name' => $item->name,
                'type_deal' => $type_deal,
                'subtype_deal' => $item->subtype_deal,
                'description' => $item->description,
                'count_views' => $item->count_views,
                //'pay_type_cash' => $item->pay_type_cash,  //todo удалить после чистки
                //'pay_type_noncash' => $item->pay_type_noncash,  //todo удалить после чистки
                'budget_from' => $item->budget_from, 
                'budget_to' => $item->budget_to,
                //'fast_deal' => $item->fast_deal, //todo удалить после чистки
                //'favorite_only' => $item->favorite_only, //todo удалить после чистки
                'deadline_deal' => $item->deadline_deal, 
                //'deadline_service' => $item->deadline_service, //todo удалить после чистки
                'question' => $user ? $item->question : null,
            
                'finish' => $item->finish,
                'finished_at' => $item->finished_at,
                'status' => $item->status,
                'is_need_kp' => $item->is_need_kp,
                'payment_status' => $item->payment_status,
                'winner' => ($user && $item->winner_id == $user->organization_id) ? true : null,
                'winner_id' => $item->winner_id,
                'categories' => $item->categories->map(function ($itm, $key) {
                    $catIcon = \App\Repositories\CategoryRepository::getRootParentFromId($itm->id);
                    return collect([
                        'id' => $itm->id,
                        'name' => $itm->name,
                        'cl_icon' => $catIcon->cl_icon,
                        'cl_background' => $catIcon->cl_background,
                    ]);
                }),
                'cities' => $item->cities->map(function ($itm, $key) {
                    return collect([
                        'id' => $itm->id,
                        'name' => $itm->name,
                    ]);
                }),
                'imagesDeals' => $item->imagesDeals->map(function ($itm, $key) {
                    return collect([
                        'id' => $itm->id,
                        'path' => $itm->file_full_path,
                    ]);
                }),
                'favourited' =>  $curUserId ? 
                                (
                                    ($item->favouritedFromUsers->search(function ($item, $key) use ( $curUserId) {
                                        return $item->id === $curUserId;
                                    }) !== false) ? true: false
                                ) : 
                                false,
                // 'favouritedFromUsers' => $item->favouritedFromUsers->map(function ($itm, $key) {
                //     return collect([
                //         'id' => $itm->id,
                //     ]);
                // }),
                'questions' => (!$user || !$item->relationLoaded('questions')) ? null : $item->questions->map(function ($itm, $key) {
                    return collect([
                        'id' => $itm->id,
                        'name' => $itm->name,
                        'question' => $itm->question,
                    ]);
                }),
                'members' => (!$user || !$item->relationLoaded('members')) ? null : $item->members->map(function ($itm, $key) {
                    return collect([
                        'organization' => OrganizationItemFormatter::format($itm),
                        'answers' => isset($itm['deal_answers']) ? $itm['deal_answers'] : null,
                    ])->reject(function ($item) {
                        return is_null($item);
                    });
                }),
            ];

            // если объявление о покупке и его id в списке id которые проплатил юзер или это свое же объявление  или же просто объявление о продаже - контакты ПОКАЗАТЬ
            if( $isLogined === true  AND
                (
                    ($type_deal ===  OrganizationDeal::DEAL_TYPE_BUY and (isset($idsDealsBuyContacts[$item->id]) or $item->user->id === $curUserId))  or
                     $type_deal ===  OrganizationDeal::DEAL_TYPE_SELL or
                     $isProAccount === true
                )
            ){

                if($item->user->is_org_created){
                    $arToCollect['organization'] = (!$item->organization) ? null : [
                        'id' => $item->organization->id,
                        'name' => $item->organization->org_name,
                        'org_products' => $item->organization->org_products,
                    ];
                }
              
                $arToCollect['owner'] = [
                    'id' => $item->user->id,
                    'name' => $item->user->name,
                    // 'unique_id' => $item->user->unique_id,
                    'is_org_created' => $item->user->is_org_created,
                    'photo' => $item->user->photo,
                    'email' => $item->user->email,
                    'phone' => $item->user->phone,
                ];
            }

            $ret = collect($arToCollect)->reject(function ($item) {
                return is_null($item);
            });

            return  $ret;
        }
       	catch(\Exception $e){
            return ['result' => false, 'error' => $e->getMessage()];
		}
       
    }

    public static function formatPaginator(Paginator $paginator)
    {
        $count = $paginator->count();
        $hasMore = $paginator->hasMorePages();
        $items = $paginator->map(function($item, $key) {
            return self::format($item);
        });

        return [
            'count' => $count,
            'hasMore' => $hasMore,
            'items' => $items,
        ];
    }

}