<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAdmin extends Model
{
    protected $table='logs_admin';

    protected $fillable=[
        'method',
        'data',
        'user_id'
    ];

}
