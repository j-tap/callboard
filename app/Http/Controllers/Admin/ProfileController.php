<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ProfileController extends Controller
{

    /**
     * @return array
     */
    public function profile()
    {
        $user = Auth::user();

        return [
            'user' => $user,
            'permissions' => $user->getPermissionsStruct()
        ];
    }

}
