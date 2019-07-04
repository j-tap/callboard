<?php

namespace App\Models\Kladr;

use Illuminate\Database\Eloquent\Model;

class GeoCoder extends Model
{
    protected $table = 'geo_coder';
    protected $fillable = ['city_id', 'ip_from', 'ip_to'];
    public $timestamps = false;
}
