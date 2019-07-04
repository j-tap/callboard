<?php
/**
 * Created by black40x@yandex.ru
 * Date: 11.10.2018
 */

namespace App\Formatter\Api\v1;


use App\Formatter\Formatter;
use Illuminate\Pagination\Paginator;

class NewsItemFormatter extends Formatter
{
    public static function format($item)
    {
        if (isset($item->categories)) {
            $categories = $item->categories->map(function ($cat, $key) {
                return collect([
                    'id' => $cat->id,
                    'name' => $cat->name,
                ]);
            });
        } else $categories = [];

        return collect([
            'id' => $item->id,
            'date_create' => $item->created_at,
            'date_update' => $item->updated_at,

            'title' => $item->title,
            'description' => $item->description,
            'shortdesc' => substr($item->description, 0, 120) . '...',
            'url' => $item->url,

            'media' => [
                'image_1' => $item->image_1,
                'image_2' => $item->image_2,
                'image_3' => $item->image_3,
            ],

            'organization' => (!$item->user->organization) ? null : [
                'id' => $item->user->organization->id,
                'name' => $item->user->organization->org_name,
            ],
            'owner' => [
                'id' => $item->user->id,
                'name' => $item->user->name,
            ],
            'city' => (!$item->city && !$item->city_id) ? null : [
                'id' => $item->city ? $item->city->id : $item->city_id,
                'name' => $item->city ? $item->city->name : $item->city_name
            ],
            'region' => (!$item->city && !$item->city_id) ? null : [
                'id' => $item->city ? $item->city->region->id : $item->region_id,
                'name' => $item->city ? $item->city->region->name : $item->region_name
            ],
            'country' => (!$item->city && !$item->city_id) ? null : [
                'id' => $item->city ? $item->city->region->country->id : $item->country_id,
                'name' => $item->city ? $item->city->region->country->name : $item->country_name
            ],
            'categories' => $categories,
        ])->reject(function ($item) {
            return is_null($item);
        });
    }

    public static function formatPaginator(Paginator $paginator)
    {
        $count = $paginator->count();
        $hasMore = $paginator->hasMorePages();
        $items = $paginator->map(function($item, $key) {
            return self::format($item);
        });

        return [
            'count' => $count,
            'hasMore' => $hasMore,
            'items' => $items,
        ];
    }
}