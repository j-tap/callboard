<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdService extends Model
{
    protected $table = 'ad_services';
    protected $fillable = ['name', 'slug', 'days', 'cost'];
}
