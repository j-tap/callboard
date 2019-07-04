<?php
/**
 * Created by black40x@yandex.ru
 * Date: 09.10.2018
 */

namespace App\Services\Yandex;

use GuzzleHttp;

class GeoCoder
{

    const ENTRY_POINT = 'https://geocode-maps.yandex.ru/1.x/';

    public function getBestAddress($query)
    {
        $client = new GuzzleHttp\Client();
        $response = $client->request('GET', self::ENTRY_POINT . '?format=json&results=1&geocode=' . urlencode($query), []);
        $struct = json_decode($response->getBody(), true);

        if (isset($struct['response']['GeoObjectCollection']['featureMember'][0]))
            return $struct['response']['GeoObjectCollection']['featureMember'][0]['GeoObject'];

        return false;
    }

}