<?php
/**
 * Created by black40x@yandex.ru / info@yksoft.ru
 * Date: 20.08.18
 */


namespace App\Repositories;

use App\Models\Category;
use Cache;

class CategoryRepository
{

    /**
     * Build tree
     *
     * @param $source
     * @return array
     */
    public static function makeNested($source)
    {
        $nested = [];

        foreach ($source as &$s) {
            if ($s['parent_id'] == 0) {
                $nested[] = &$s;
            } else {
                $pid = $s['parent_id'];
                if (isset($source[$pid])) {
                    if (!isset($source[$pid]['items'])) {
                        $source[$pid]['items'] = [];
                    }
                    $source[$pid]['items'][] = &$s;
                }
            }
        }
        return $nested;
    }

    /**
     * Get all categories tree
     *
     * @return array
     */
    public static function getCategoryTree()
    {
        return Cache::remember('api.category.tree', config('b2b.cache_time'), function () {
            return self::makeNested(Category::all(['id', 'parent_id', 'name', 'description', 'cl_icon', 'cl_background'])->keyBy('id')->toArray());
        });
    }

    public static function getCategoryIdList()
    {
        return Cache::remember('api.category.id.list', config('b2b.cache_time'), function () {
            return Category::all(['id', 'parent_id'])->keyBy('id')->toArray();
        });
    }

    public static function getIncludedIds($tree, $id)
    {
        $ids = [];

        foreach ($tree as $node) {
            if ($node['parent_id'] == $id) {
                $ids[] = $node['id'];
                $ids = array_merge($ids, self::getIncludedIds($tree, $node['id']));
            }
        }

        return $ids;
    }

    public static function getIncludedTree($categories)
    {
        $tree = self::getCategoryIdList();
        $allCategories = [];

        foreach ($categories as $category) {
            if (isset($tree[$category])) {
                $allCategories[] = $category;
                $allCategories = array_merge($allCategories, self::getIncludedIds($tree, $category));
            }
        }

        return $allCategories;
    }

    public static function getRootParentFromId($id){

        $curRow = Category::find($id);
        $parentRow =  $curRow->parent()->first();
        if ($parentRow !== null){
            $curRow = \App\Repositories\CategoryRepository::getRootParentFromId($parentRow->id);
        }
        
        return $curRow;
    }
}