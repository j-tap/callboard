<?php
/**
 * Created by black40x@yandex.ru
 * Date: 10.10.2018
 */

namespace App\Traits;


trait PermissionsRequestTrait
{

    public function extractPermission()
    {
        $userPermissions = [];

        if (isset($this->permissions))
            foreach ($this->permissions as $slug => $permissions) {
                foreach ($permissions as $permission => $check) {
                    if ($check)
                        $userPermissions[] = $slug . '.' . $permission;
                }
            }

        return $userPermissions;
    }

}