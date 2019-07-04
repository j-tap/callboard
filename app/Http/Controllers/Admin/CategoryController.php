<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Traits\ApiControllerTrait;
use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use ApiControllerTrait;

    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        return CategoryRepository::getCategoryTree();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(CategoryRequest $request)
    {
        Cache::forget('api.category.tree');
        return Category::create($request->all());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return Category::findOrFail($id, ['id', 'parent_id', 'name', 'description', 'cl_icon', 'cl_background']);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(CategoryRequest $request, $id)
    {
        $question = Category::findOrFail($id, ['id', 'parent_id', 'name', 'description', 'cl_icon', 'cl_background']);
        $question->update($request->all());

        Cache::forget('api.category.tree');
        return $question;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        Cache::forget('api.category.tree');
        return $this->successResponse();
    }
}
