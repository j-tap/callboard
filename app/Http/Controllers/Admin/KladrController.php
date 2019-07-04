<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Kladr\CityRequest;
use App\Http\Requests\Admin\Kladr\RegionRequest;
use App\Http\Requests\Admin\Kladr\CountryRequest;
use App\Models\Kladr\City;
use App\Models\Kladr\Country;
use App\Models\Kladr\Region;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KladrController extends Controller
{

    use ApiControllerTrait;

    public function getCountries()
    {
        return Country::all(['id', 'name']);
    }

    public function getRegions($country)
    {
        return Region::select(['id', 'name'])->where('country_id', $country)->orderBy('name', 'ASC')->get();
    }

    public function getCities($region)
    {
        return City::select(['id', 'name'])->where('region_id', $region)->orderBy('pos', 'DESC')->orderBy('name', 'ASC')->get();
    }

    // City
    public function cityStore(CityRequest $request)
    {
        return City::create($request->all());
    }

    public function cityShow($id)
    {
        return City::findOrFail($id, ['id', 'name', 'region_id', 'geo_lat', 'geo_lon', 'pos']);
    }

    public function cityUpdate(CityRequest $request, $id)
    {
        $city = City::findOrFail($id, ['id', 'name', 'geo_lat', 'geo_lon', 'pos']);
        $city->update($request->all());

        return $city;
    }

    public function cityDelete($id)
    {
        City::findOrFail($id)->delete();
        return $this->successResponse();
    }

    // Region
    public function regionStore(RegionRequest $request)
    {
        return Region::create($request->all());
    }

    public function regionShow($id)
    {
        return Region::findOrFail($id, ['id', 'name', 'country_id']);
    }

    public function regionUpdate(RegionRequest $request, $id)
    {
        $question = Region::findOrFail($id, ['id', 'name']);
        $question->update($request->all());

        return $question;
    }

    public function regionDelete($id)
    {
        Region::findOrFail($id)->delete();
        return $this->successResponse();
    }

    // Country
    public function countryStore(CountryRequest $request)
    {
        return Country::create($request->all());
    }

    public function countryShow($id)
    {
        return Country::findOrFail($id, ['id', 'name']);
    }

    public function countryUpdate(CountryRequest $request, $id)
    {
        $question = Country::findOrFail($id, ['id', 'name']);
        $question->update($request->all());

        return $question;
    }

    public function countryDelete($id)
    {
        Country::findOrFail($id)->delete();
        return $this->successResponse();
    }
}
