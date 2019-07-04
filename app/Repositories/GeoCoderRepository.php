<?php
/**
 * Created by black40x@yandex.ru
 * Date: 25/10/2018
 */

namespace App\Repositories;

use DB;

class GeoCoderRepository
{

    public static function getClientCity($ip_addr)
    {
        return DB::select("SELECT * FROM geo_coder WHERE (INET_ATON(?) BETWEEN INET_ATON(ip_from) AND INET_ATON(ip_to)) LIMIT 1", [$ip_addr]);
    }

}