<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function permissions()
    {
        return config('b2b.permissions');
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function permissionsSite()
    {
        return config('b2b.permissions_site');
    }

}
