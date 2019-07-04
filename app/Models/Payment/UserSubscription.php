<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscription extends Model
{
    use SoftDeletes;

    protected $table = 'user_subscriptions';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subscription_id', 'user_id', 'deal_id', 'description', 'started_at', 'finished_at', 'duration_days', 'status', 'cost'
    ];

    static protected $sortable = [ 'subscription_id', 'user_id', 'deal_id', 'description', 'started_at', 'finished_at', 'duration_days', 'status', 'cost'];

    // /**
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
    //  */
    // protected $hidden = [
    //     'id'
    // ];

    protected $dates = ['deleted_at', 'started_at', 'finished_at'];

    public static function getСostOfService($slug)
    {
        $ret = self::where('slug', $slug)->first();

        if($ret){
            return $ret->cost;
        }
   
        return null;
    }

   
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function subscription()
    // {
    //    // return $this->belongsTo(\App\Models\Payment\Subscription::class, 'subscription_id')->select('id', 'name');
    //     return $this->belongsTo(\App\Models\Payment\Subscription::class, 'subscription_id');
    // }

    public function subscription()
    {
       // return $this->belongsTo(\App\Models\Payment\Subscription::class, 'subscription_id')->select('id', 'name');
        return $this->belongsTo(\App\Models\Payment\Subscription::class, 'subscription_id')->with(['parent']);
    }
}
