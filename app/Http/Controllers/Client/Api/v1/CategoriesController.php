<?php

namespace App\Http\Controllers\Client\Api\v1;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Traits\ApiControllerTrait;
use App\Http\Controllers\Controller;
use Cache;

class CategoriesController extends Controller
{

    use ApiControllerTrait;

    public function categoryTree()
    {
        return $this->successResponse(
            Cache::remember('api.categories.tree',  config('b2b.cache_time'), function() {
                return CategoryRepository::getCategoryTree();
            })
        );
    }

}
