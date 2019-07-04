<?php

namespace App\Http\Controllers\Client\Api\v1;

use App\Repositories\GeoCoderRepository;
use Cache;
use App\Traits\ApiControllerTrait;
use App\Http\Controllers\Controller;
use App\Models\Kladr\Country;
use App\Models\Kladr\Region;
use App\Models\Kladr\City;
use Illuminate\Http\Request;
use DB;

class KladrController extends Controller
{
    use ApiControllerTrait;

    public function getCountries()
    {
        return $this->successResponse(Cache::remember('api.countries', config('b2b.cache_time'), function() {
            return Country::orderBy('name', 'ASC')->get(['id', 'name']);
        }));
    }

    public function getRegions($country)
    {
        return $this->successResponse(Cache::remember('api.regions.' . $country, config('b2b.cache_time'), function() use ($country) {
            return Region::select(['id', 'name'])->where('country_id', $country)->orderBy('name', 'ASC')->get();
        }));
    }

    public function getCities($region)
    {
        return $this->successResponse(Cache::remember('api.cities.' . $region, config('b2b.cache_time'), function() use ($region) {
            return City::select(['id', 'name', 'geo_lat', 'geo_lon'])->where('region_id', $region)->orderBy('pos', 'DESC')->orderBy('name', 'ASC')->get();
        }));
    }

    public function getCountry($country)
    {
        if (!$result = Cache::remember('api.country.' . $country, config('b2b.cache_time'), function() use ($country) {
            return Country::select('id', 'name')->find($country);
        })) return $this->errorResponse();

        return $this->successResponse($result);
    }

    public function getRegion($region)
    {
        if (!$result = Cache::remember('api.region.info.' . $region, config('b2b.cache_time'), function() use ($region) {
            return Region::select('id', 'name', 'country_id')->with('country')->find($region);
        })) return $this->errorResponse();

        return $this->successResponse([
            'id' => $result->id,
            'name' => $result->name,
            'country' => [
                'id' => $result->country->id,
                'name' => $result->country->name,
            ]
        ]);
    }

    public function getPlace(Request $request)
    {
        if ($query = $request->get('query')) {
            $regions = Region::select(['id', 'name'])->where('name', 'like', '%'.$query.'%')->get()->take(5);
          //  $cities = City::select(['id', 'name', 'geo_lat', 'geo_lon'])->where('name', 'like', '%'.$query.'%')->get()->take(5); // todo удалить при чистке
            $cities = DB::table('cities')->leftJoin('regions', 'cities.region_id', '=' , 'regions.id')->
                            select(['cities.id', 'cities.name', 'cities.geo_lat', 'cities.geo_lon', 'regions.id as region_id', 'regions.name as region_name'])->
                            where('cities.name', 'like', '%'.$query.'%')->take(5)->get();
            $cities =  $cities;
            return $this->successResponse([
                'regions' => $regions,
                'cities' => $cities,
            ]);
        } else
            return response()->json($this->errorResponse(['message' => 'Empty request query']));
    }

    public function getPosition(Request $request)
    {
        if ($city_id = $request->get('city', null)) {
            $city = City::select(['id', 'name', 'geo_lat', 'geo_lon', 'region_id'])->with('region.country')->find($city_id);;
        } else {
            $geo = GeoCoderRepository::getClientCity($request->ip());

            if (!empty($geo)) {
                $city = City::select(['id', 'name', 'geo_lat', 'geo_lon', 'region_id'])->with('region.country')->find($geo[0]->city_id);
            } else {
                $city = City::select(['id', 'name', 'geo_lat', 'geo_lon', 'region_id'])->with('region.country')->where('pos', 99999)->first();
            }
        }

        if (!$city)
            return $this->errorResponse();

        return $this->successResponse([
            'city' => [
                'id' => $city->id,
                'name' => $city->name,
                'location' => [
                    'lat' => $city->geo_lat,
                    'lon' => $city->geo_lon,
                ]
            ],
            'region' => [
                'id' => $city->region->id,
                'name' => $city->region->name,
            ],
            'country' => [
                'id' => $city->region->country->id,
                'name' => $city->region->country->name,
            ],
        ]);
    }
}
