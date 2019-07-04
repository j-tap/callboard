<?php

namespace App\Models\Kladr;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'country_id'];
    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo(\App\Models\Kladr\Country::class);
    }

    public function cities()
    {
        return $this->hasMany(\App\Models\Kladr\City::class);
    }
}
