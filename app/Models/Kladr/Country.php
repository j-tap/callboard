<?php

namespace App\Models\Kladr;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function regions()
    {
        return $this->hasMany(\App\Models\Kladr\Region::class);
    }
}
