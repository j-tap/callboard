<?php
/**
 * Created by black40x@yandex.ru
 * Date: 09.10.2018
 */

namespace App\Repositories\Filters;

use App\Models\Org\Organization;
use App\Repositories\CategoryRepository;
use Auth;
use DB;

class FilterOrganizationRepository
{

    /**
     * Filter organization by Kladr and Category
     *
     * @param bool $categories
     * @param bool $countries
     * @param bool $regions
     * @param bool $cities
     * @return \Illuminate\Database\Eloquent
     */
    public static function filter($categories = false, $countries = false, $regions = false, $cities = false, $search = null)
    {
        $query = Organization::query()->select([
            'organizations.*',
            'organizations.id as id',
            'cities.id as city_id',
            'cities.name as city_name',
            'regions.id as region_id',
            'regions.name as region_name',
            'countries.id as country_id',
            'countries.name as country_name',
        ]);

        // Left Join for filter query
        $query->leftJoin('cities', function ($join) {
            $join->on('organizations.org_city_id', '=', 'cities.id');
        });

        $query->leftJoin('regions', function ($join) {
            $join->on('cities.region_id', '=', 'regions.id');
        });

        $query->leftJoin('countries', function ($join) {
            $join->on('regions.country_id', '=', 'countries.id');
        });

        $query->leftJoin('organizations_categories', function ($join) {
            $join->on('organizations_categories.organization_id', '=', 'organizations.id');
        });

        $query->leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'organizations.owner_id');
        });

        // Is organization in favorites?
        // if ($user = Auth::guard('api')->user()) {
        //     $query->leftJoin('user_favorites', function ($join) use ($user) {
        //         $join->on('user_favorites.favorite_id', '=', 'organizations.id')
        //              ->on(DB::raw('user_favorites.organization_id'), DB::raw('='),DB::raw("'".$user->organization_id."'"));
        //     });

        //     $query->addSelect(['user_favorites.favorite_id as favorite']);
        // }

        // Queries
        $query->where('users.is_org_created', '=', true);
        if (!empty($cities)) $query->whereIn('org_city_id', $cities);
        if (!empty($regions)) $query->whereIn('region_id', $regions);
        if (!empty($countries)) $query->whereIn('country_id', $countries);
        // ToDo - Some problem with included categories? Don't forget check child tree!
        if (!empty($categories)) $query->whereIn('organizations_categories.category_id', CategoryRepository::getIncludedTree($categories));

        if ($search && strlen($search) > 1) {
            $query->where(function($query) use ($search){
                $query->where('org_products', 'like', '%'.$search.'%', 'or');
                $query->orWhere('org_name', 'like', '%'.$search.'%');
                $query->orWhere('org_description', 'like', '%'.$search.'%');
            });
        }

        $query->orderBy('organizations.created_at', 'desc');

        return $query->groupBy('id')->with('categories', 'legalForm', 'stores', 'offices', 'city.region.country');
    }

}