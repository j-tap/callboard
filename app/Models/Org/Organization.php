<?php

namespace App\Models\Org;

use App\Classes\Business\WorkTime;
use App\Models\Basic\DatatableModel;
use App\Models\News;
use App\Models\User;
use App\Traits\DataTable;
use App\Traits\ModelFileUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class Organization extends Model
{
    use Notifiable;
    use ModelFileUpload;
    use SoftDeletes;
    use DataTable;

    // Use in ENUM in database
    const ORG_TYPE_SELLER = 'seller';
    const ORG_TYPE_BUYER = 'buyer';

    const ORG_STATUS_REGISTRED = 'register';
    const ORG_STATUS_APPROVE = 'approve';
    const ORG_STATUS_ARCHIVE = 'archive';

    protected $hidden = ['pivot'];
    protected $guarded = ['id', 'user_id'];
    protected $fillable = [
        'first_name',
        'second_name',
        'middle_name',
        'phone',
        'org_city_id',
        'org_type',
        'org_name',
        'org_inn',
        'org_kpp',
        'org_address',
        'org_address_legal',
        'org_legal_form_id',
        'org_director',
        'org_site',
        'org_description',
        'org_status',
        'org_work_time',
        'org_products',
    ];

    protected $dates = ['deleted_at'];

    static protected $sortable = ['id', 'org_name', 'org_inn', 'org_kpp', 'org_status', 'org_city_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(\App\Models\Kladr\City::class, 'org_city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stores()
    {
        return $this->hasMany(\App\Models\Org\OrganizationStore::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offices()
    {
        return $this->hasMany(\App\Models\Org\OrganizationOffice::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(\App\Models\Category::class, 'organizations_categories', 'organization_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites()
    {
        return $this->belongsToMany(\App\Models\Org\Organization::class, 'user_favorites', 'organization_id', 'favorite_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deals()
    {
        return $this->hasMany(\App\Models\Org\OrganizationDeal::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function legalForm()
    {
        return $this->belongsTo(\App\Models\Org\OrganizationLegalForm::class, 'org_legal_form_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedback()
    {
        return $this->hasMany(\App\Models\Feedback::class, 'org_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function news()
    {
        return $this->hasManyThrough(\App\Models\News::class, \App\Models\User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ratings()
    {
        return $this->hasMany(\App\Models\Org\OrganizationRate::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function answers()
    {
        return $this->hasMany(\App\Models\Org\OrganizationDealAnswer::class, 'organization_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(\App\Models\Org\OrganizationNotification::class, 'organization_id')->orderBy('created_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dialogs_seller()
    {
        return $this->hasMany(\App\Models\Dialog::class, 'seller_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dialogs_buyer()
    {
        return $this->hasMany(\App\Models\Dialog::class, 'buyer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dialogs_all()
    {
        $organization_id = $this->id;
        return \App\Models\Dialog::where('buyer_id',  $organization_id)->orWhere('seller_id',  $organization_id);
    }

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRegister($query)
    {
        return $query->where('org_status', self::ORG_STATUS_REGISTRED);
    }

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApprove($query)
    {
        return $query->where('org_status', self::ORG_STATUS_APPROVE);
    }

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchive($query)
    {
        return $query->where('org_status', self::ORG_STATUS_ARCHIVE);
    }

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSeller($query)
    {
        return $query->where('org_type', self::ORG_TYPE_SELLER);
    }

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBuyer($query)
    {
        return $query->where('org_type', self::ORG_TYPE_BUYER);
    }

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeModerate($query)
    {
        return $query->where('on_moderate', 1);
    }

    /**
     * @param User $user
     */
    public function createUser($user)
    {
        $this->users()->insert($user);
    }

    public function setOrgWorkTimeAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['org_work_time'] = WorkTime::workTimeToStr($value);
        } else {
            $this->attributes['org_work_time'] = $value;
        }
    }

    public function updateRating()
    {
        $rating = $this->ratings()->selectRaw('count(*) as count, sum(rate) as rating')->first();
        $this->rating = number_format((float) ($rating['rating'] / $rating['count']), 2, '.', '');
        $this->save();
    }

    public function uploadFiles(Request $request, $resizeValMaxPx = null )
    {
        
        try{
            $userId = $this->owner->id;
            $path = 'users/' . $userId . '/organizations/' . $this->id . '/images';
            $this->logo = $this->uploadFile($request, 'logo', $path , $this->logo, $resizeValMaxPx);

           // if ($this->org_type == self::ORG_TYPE_SELLER) {
                $this->image_1 = $this->uploadFile($request, 'image_1', $path, $this->image_1, $resizeValMaxPx);
                $this->image_2 = $this->uploadFile($request, 'image_2', $path, $this->image_2, $resizeValMaxPx);
                $this->image_3 = $this->uploadFile($request, 'image_3', $path, $this->image_3, $resizeValMaxPx);
                $this->video = $this->uploadFile($request, 'video', $path, $this->video);
            //}
    
           return $this->save();
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
       
    }

    
    /**
     *  Есть ли телефон
     */
    public function phoneExist()
    {
        if($this->phone === null  or $this->phone === ''){
            return false;
        }
        return true;
    }

}
