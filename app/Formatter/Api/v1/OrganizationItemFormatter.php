<?php
/**
 * Created by black40x@yandex.ru
 * Date: 11.10.2018
 */

namespace App\Formatter\Api\v1;


use App\Formatter\Formatter;
use App\Classes\Business\WorkTime;
use Illuminate\Pagination\Paginator;

class OrganizationItemFormatter extends Formatter
{

    public static function format($item)
    {
        return collect([
            'id' => $item->id,
            'owner_id' => $item->owner_id,
            'owner_first_name' => $item->first_name,
            'owner_second_name' => $item->second_name,
            'owner_middle_name' => $item->middle_name,
            'contact_phone' => $item->phone,
            'favorite' => $item->favorite ? true : false,
            'rating' => $item->rating,
            'organization' => [
                'type' => ($item->org_type == 'seller') ? 'supplier' : 'customer',
                'inn' => $item->org_inn,
                'kpp' => $item->org_kpp,
                'name' => $item->org_name,
                'legal_form' => $item->legalForm ? $item->legalForm->name : null,
                'legal_form_slug' => $item->legalForm ? $item->legalForm->short_name : null,
                'director' => $item->org_director,
                'address' => $item->org_address,
                'products' => $item->org_products,
                'address_legal' => $item->org_address_legal,
                'work_time' => WorkTime::strToWorkTime($item->org_work_time),
                'email' => $item->owner->email,
                'location' => [
                    'lat' => $item->geo_lat,
                    'lon' => $item->geo_lon
                ],
                'site' => $item->org_site,
                'logo' => $item->org_logo,
                'description' => $item->org_description,
                'media' => [
                    'logo' => $item->logo,
                    'video' => $item->video,
                    'image_1' => $item->image_1,
                    'image_2' => $item->image_2,
                    'image_3' => $item->image_3,
                ],
                'status'=> $item ->org_status,
            ],
            'city' => !$item->relationLoaded('city') ? null : [
                'id' => $item->city ? $item->city->id : $item->city_id,
                'name' => $item->city ? $item->city->name : $item->city_name
            ],
            'region' => !$item->relationLoaded('city') ? null : [
                'id' => $item->city ? $item->city->region->id : $item->region_id,
                'name' => $item->city ? $item->city->region->name : $item->region_name
            ],
            'country' => !$item->relationLoaded('city') ? null : [
                'id' => $item->city ? $item->city->region->country->id : $item->country_id,
                'name' => $item->city ? $item->city->region->country->name : $item->country_name
            ],
            'categories' => !$item->relationLoaded('categories') ? null : $item->categories->map(function ($cat, $key) {
                $catIcon = \App\Repositories\CategoryRepository::getRootParentFromId($cat->id);
                return collect([
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'cl_icon' => $catIcon->cl_icon,
                    'cl_background' => $catIcon->cl_background,
                ]);
            }),
            'stores' => !$item->relationLoaded('stores') ? null : $item->stores->map(function ($store, $key) {
                return collect([
                    'id' => $store->id,
                    'address' => $store->address,
                    'location' => [
                        'lat' => $store->geo_lat,
                        'lon' => $store->geo_lon
                    ],
                ]);
            }),
            'offices' => !$item->relationLoaded('offices') ? null : $item->offices->map(function ($office, $key) {
                return collect([
                    'id' => $office->id,
                    'address' => $office->address,
                    'phone'=>$office ->phone,
                    'email'=>$office ->email,
                    'location' => [
                        'lat' => $office->geo_lat,
                        'lon' => $office->geo_lon
                    ],
                ]);
            }),
        ])->reject(function ($item) {
            return is_null($item);
        });
    }

    public static function formatPublicProfile($item)
    {
        return collect([
            'id' => $item->id,
            'owner_first_name' => $item->first_name,
            'owner_second_name' => $item->second_name,
            'owner_middle_name' => $item->middle_name,
            'contact_phone' => $item->phone,
            'favorite' => $item->favorite ? true : false,
            'rating' => $item->rating,
            'organization' => [
                'inn' => $item->org_inn,
                'kpp' => $item->org_kpp,
                'name' => $item->org_name,
                'legal_form' => $item->legalForm ? $item->legalForm->name : null,
                'legal_form_slug' => $item->legalForm ? $item->legalForm->short_name : null,
                'director' => $item->org_director,
                'address' => $item->org_address,
                'products' => $item->org_products,
                'address_legal' => $item->org_address_legal,
                'work_time' => WorkTime::strToWorkTime($item->org_work_time),
                'email' => $item->owner->email,
                'location' => [
                    'lat' => $item->geo_lat,
                    'lon' => $item->geo_lon
                ],
                'site' => $item->org_site,
                'logo' => $item->org_logo,
                'description' => $item->org_description,
                'media' => [
                    'logo' => $item->logo,
                    'video' => $item->video,
                    'image_1' => $item->image_1,
                    'image_2' => $item->image_2,
                    'image_3' => $item->image_3,
                ],
            ],
            'city' => !$item->relationLoaded('city') ? null : [
                'id' => $item->city ? $item->city->id : $item->city_id,
                'name' => $item->city ? $item->city->name : $item->city_name
            ],
            'region' => !$item->relationLoaded('city') ? null : [
                'id' => $item->city ? $item->city->region->id : $item->region_id,
                'name' => $item->city ? $item->city->region->name : $item->region_name
            ],
            'country' => !$item->relationLoaded('city') ? null : [
                'id' => $item->city ? $item->city->region->country->id : $item->country_id,
                'name' => $item->city ? $item->city->region->country->name : $item->country_name
            ],
            'categories' => !$item->relationLoaded('categories') ? null : $item->categories->map(function ($cat, $key) {
                $catIcon = \App\Repositories\CategoryRepository::getRootParentFromId($cat->id);
                return collect([
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'cl_icon' => $catIcon->cl_icon,
                    'cl_background' => $catIcon->cl_background,
                ]);
            }),
            'stores' => !$item->relationLoaded('stores') ? null : $item->stores->map(function ($store, $key) {
                return collect([
                    'id' => $store->id,
                    'address' => $store->address,
                    'location' => [
                        'lat' => $store->geo_lat,
                        'lon' => $store->geo_lon
                    ],
                ]);
            }),
            'offices' => !$item->relationLoaded('offices') ? null : $item->offices->map(function ($office, $key) {
                return collect([
                    'id' => $office->id,
                    'address' => $office->address,
                    'phone'=>$office ->phone,
                    'email'=>$office ->email,
                    'location' => [
                        'lat' => $office->geo_lat,
                        'lon' => $office->geo_lon
                    ],
                ]);
            }),
        ])->reject(function ($item) {
            return is_null($item);
        });
    }

    public static function formatMarkers(Paginator $paginator)
    {
        $items = $paginator->map(function($item, $key) {
            return [
                'id' => $item->id,
                'location' => [
                    'lat' => $item->geo_lat,
                    'lon' => $item->geo_lon
                ],
                'stores' => $item->stores->map(function ($store, $key) {
                    return collect([
                        'id' => $store->id,
                        'address' => $store->address,
                        'location' => [
                            'lat' => $store->geo_lat,
                            'lon' => $store->geo_lon
                        ],
                    ]);
                }),
                'offices' => $item->offices->map(function ($office, $key) {
                    return collect([
                        'id' => $office->id,
                        'address' => $office->address,
                        'location' => [
                            'lat' => $office->geo_lat,
                            'lon' => $office->geo_lon
                        ],
                    ]);
                }),
            ];
        });

        return [
            'count' => $paginator->count(),
            'hasMore' => $paginator->hasMorePages(),
            'items' => $items,
        ];
    }

    public static function formatPaginator(Paginator $paginator, $mapper = null)
    {
        $count = $paginator->count();
        $hasMore = $paginator->hasMorePages();
        $items = $paginator->map(function($item, $key) use ($mapper) {
            if ($mapper) {
                $item = $mapper->__invoke($item);
            }
            return self::format($item);
        });

        return [
            'count' => $count,
            'hasMore' => $hasMore,
            'items' => $items,
        ];
    }

}