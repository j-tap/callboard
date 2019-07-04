<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Payment\UserSubscription;

class Subscription extends Model
{
    use SoftDeletes;

    const SUBSCRIPTION_STATUS_ACTIVE     = 'active'; // акция или тариф активны
    const SUBSCRIPTION_STATUS_FINISHED   = 'finished';  // акция или тариф завершены
    const SUBSCRIPTION_STATUS_PAUSE      = 'pause'; // акция или тариф не в работе
    
    const SUBSCRIPTION_TYPE_TARIFF       = 'tariff'; // тип платной услуги - тариф
    const SUBSCRIPTION_TYPE_SERVICE      = 'service'; // тип платной услуги - сервис
    
    const SUBSCRIPTION_PAYMENT_ALL_IN                         = 'payment_all_in'; // Про аккаунт, все включено
    const SUBSCRIPTION_PAYMENT_ALL_IN_3_MONTHS                = 'payment_all_in_3_months'; // Про аккаунт, все включено на 3 месяца
    const SUBSCRIPTION_PAYMENT_ALL_IN_6_MONTHS                = 'payment_all_in_6_months'; // Про аккаунт, все включено на 6 месяцев
    const SUBSCRIPTION_PAYMENT_ALL_IN_3_DAYS                  = 'payment_all_in_3_days'; // Про аккаунт, все включено на 3 дня
    const SUBSCRIPTION_PAYMENT_ONCE_DEAL_SELL                 = 'payment_once_deal_sell'; // Оплата размещения заявки о продаже
    const SUBSCRIPTION_PAYMENT_ONCE_DEAL_SELL_AFTER_30_DAYS   = 'payment_once_deal_sell_after_30_days'; // Продление одного объявления по истечению срока размещения на 30 дней
    const SUBSCRIPTION_PAYMENT_ONCE_DEAL_BUY_GET_CONTACTS     = 'payment_once_deal_buy_get_contacts'; // Получить контакты пользователя заявки о продаже

    const SUBSCRIPTION_PAYMENT_ALWAYS_DEAL_BUY_MAIL_NOTIFICATION     = 'payment_always_deal_buy_mail_notification'; // Получать уведомления по почте заявки о продаже


    protected $table = 'subscriptions';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'started_at', 'finished_at', 'duration_days', 'status', 'cost', 'parent_id', 'type'
    ];

    static protected $sortable = ['id', 'name', 'description', 'started_at', 'finished_at', 'duration_days', 'status', 'cost'];

    protected $dates = ['deleted_at', 'started_at', 'finished_at'];

    /**
     *  Вернуть сервисы, кототорые доступны юзеру для подписки
     * 
     * getServiceFromUserPossibleActivation
     *
     * @return array
     */
    public static function getServiceFromUserPossible()
    {
        return[ 
            Subscription::SUBSCRIPTION_PAYMENT_ONCE_DEAL_SELL ,
            Subscription::SUBSCRIPTION_PAYMENT_ONCE_DEAL_SELL_AFTER_30_DAYS ,
            Subscription::SUBSCRIPTION_PAYMENT_ONCE_DEAL_BUY_GET_CONTACTS ,
        ];

    }

    /**
     *  Вернуть тарифы, кототорые доступны юзеру для подписки
     * 
     * getServiceFromUserPossibleActivation
     *
     * @return array
     */
    public static function getTariffFromUserPossible()
    {
        return[ 
            Subscription::SUBSCRIPTION_PAYMENT_ALL_IN,
            Subscription::SUBSCRIPTION_PAYMENT_ALL_IN_3_MONTHS,
            Subscription::SUBSCRIPTION_PAYMENT_ALL_IN_6_MONTHS,
            Subscription::SUBSCRIPTION_PAYMENT_ALL_IN_3_DAYS ,
        ];

    }

    /**
     *  Вернуть сервисы, кототорые юзер может активировать самостоятельно
     * 
     * getServiceFromUserPossibleActivation
     *
     * @return array
     */
    public static function getServiceFromUserPossibleActivation()
    {
        return[ 
            Subscription::SUBSCRIPTION_PAYMENT_ALL_IN_3_DAYS,
        ];

    }

    public static function getСostOfServiceFromSlug($slug)
    {
        $ret = self::where('slug', $slug)->first();

        if($ret){
            return $ret->cost;
        }
   
        return null;
    }

    public static function getСostOfServiceFromId($id)
    {
        $ret = self::select('cost')->where('id', '=', $id)->first();

        if($ret){
            return $ret->cost;
        }
   
        return null;
    }

    public static function getNameOfServiceFromSlug($slug)
    {
        $ret = self::where('slug', $slug)->first();

        if($ret){
            return $ret->name;
        }
   
        return null;
    }

    public static function getServiceFromSlug($slug)
    {
        $ret = self::where('slug', $slug)->first();

        if($ret){
            return $ret;
        }
   
        return null;
    }

    public static function isActiveServiceFromSlug($slug)
    {

        $curRow = self::where('slug', $slug)->where('status', Subscription::SUBSCRIPTION_STATUS_ACTIVE)->first();

        if($curRow === null){
            return false;
        }

        $parentRow =  $curRow->parent()->first();

        if ($parentRow !== null){
            $curRow = Subscription::isActiveServiceFromSlug($parentRow->slug);
        }
        
        if($curRow){
            return true;
        }
        
        return false;
    }

    public static function getIdOfServiceFromSlug($slug)
    {
        $ret = self::select('id')->where('slug', $slug)->first();

        if($ret){
            return $ret->id;
        }
   
        return null;
    }

    public static function getDurationDaysFromId($id)
    {
        $ret = self::select('duration_days')->where('id', '=', $id)->first();

        if($ret){
            return $ret->duration_days;
        }
   
        return null;
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userSubscriptions()
    {
        return $this->hasMany(\App\Models\Payment\UserSubscription::class, 'subscription_id');
    }

    public static function getRootParentFromId($id){

        $curRow = self::find($id);
        $parentRow =  $curRow->parent()->first();
        if ($parentRow !== null){
            $curRow = Subscription::getRootParentFromId($parentRow->id);
        }
        
        return $curRow;
    }

    
    // public static function activeSubscription()
    // {

    //     $activeSubscriptions =  self::where('status', '=', Subscription::SUBSCRIPTION_STATUS_ACTIVE)->get();

    //     foreach( $activeSubscriptions as $key => $activeSubscription){

    //        if(  $activeSubscription->status !== Subscription::SUBSCRIPTION_STATUS_ACTIVE or
    //            ($activeSubscription->parent_id !== null and  $activeSubscription->subscription->parent->status !== Subscription::SUBSCRIPTION_STATUS_ACTIVE)){

    //             $activeSubscriptions->forget($key);

    //        }
    //     }

    //     return $activeSubscriptions;
    //    // return $this->activeSubscriptions()->with(['subscription']);
    // }

    public function parent()
    {
        return $this->belongsTo(\App\Models\Payment\Subscription::class, 'parent_id');
    }

}
