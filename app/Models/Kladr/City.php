<?php

namespace App\Models\Kladr;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'federal', 'region_id', 'geo_lat', 'geo_lon', 'pos'];
    public $timestamps = false;

    public function region()
    {
        return $this->belongsTo(\App\Models\Kladr\Region::class);
    }

    public function organizations()
    {
        return $this->hasMany(\App\Models\Org\Organization::class, 'org_city_id');
    }

    public function deals()
    {
        return $this->belongsToMany(\App\Models\Org\OrganizationDeal::class, 'organizations_deal_cities', 'organization_id', 'city_id');
    }

    public function georange()
    {
        return $this->hasMany(\App\Models\Kladr\GeoCoder::class, 'city_id');
    }
}
