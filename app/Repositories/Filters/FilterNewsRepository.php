<?php
/**
 * Created by black40x@yandex.ru
 * Date: 09.10.2018
 */

namespace App\Repositories\Filters;

use App\Models\News;
use App\Models\Org\Organization;
use App\Repositories\CategoryRepository;

class FilterNewsRepository
{

    /**
     * Filter News by Kladr and Categories
     *
     * @param bool $categories
     * @param bool $countries
     * @param bool $regions
     * @param bool $cities
     * @return $this
     */
    public static function filter($categories = false, $countries = false, $regions = false, $cities = false)
    {
        $query = News::query()->select(
            'news.*',
            'cities.id as city_id',
            'cities.name as city_name',
            'regions.id as region_id',
            'regions.name as region_name',
            'countries.id as country_id',
            'countries.name as country_name')->groupBy('news.id');

        // Check is Organization
        $query->leftJoin('users', function ($join) {$join->on('news.user_id', '=', 'users.id');});
        $query->leftJoin('organizations', function ($join) {
            $join->on('users.organization_id', '=', 'organizations.id');
        });

        $query->leftJoin('cities', function ($join) {
            $join->on('organizations.org_city_id', '=', 'cities.id');
        });

        $query->leftJoin('regions', function ($join) {
            $join->on('cities.region_id', '=', 'regions.id');
        });

        $query->leftJoin('countries', function ($join) {
            $join->on('regions.country_id', '=', 'countries.id');
        });

        $query->leftJoin('news_categories', function ($join) {
            $join->on('news_categories.news_id', '=', 'news.id');
        });

        // Select News
        if (!empty($cities)) $query->whereIn('org_city_id', $cities);
        if (!empty($regions)) $query->whereIn('region_id', $regions);
        if (!empty($countries)) $query->whereIn('country_id', $countries);
        if (!empty($categories)) $query->whereIn('news_categories.category_id', CategoryRepository::getIncludedTree($categories));

        $query->where('organizations.org_type', Organization::ORG_TYPE_SELLER);
        $query->orWhereNull('users.organization_id');
        $query->orderBy('news.created_at', 'desc');

        return $query->with('categories', 'user.organization');
    }

    public static function siteNews($categories = false)
    {
        $query = News::query()->select('news.*')->groupBy('news.id');

        // Check is System
        $query->leftJoin('users', function ($join) {$join->on('news.user_id', '=', 'users.id');});
        $query->leftJoin('news_categories', function ($join) {
            $join->on('news_categories.news_id', '=', 'news.id');
        });

        // Select News
        $query->whereNull('users.organization_id');
        $query->orderBy('news.created_at', 'desc');

        // ToDo - Some problem with included categories? Don't forget check child tree!
        if (!empty($categories)) $query->whereIn('news_categories.category_id', $categories);

        return $query->with('categories');
    }
}