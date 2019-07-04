<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\Admin\NewsCreateRequest;
use App\Models\News;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    use ApiControllerTrait;

    public function news(Request $request)
    {
        return News::filtredData($request, ['id', 'title', 'created_at', 'status', 'stock', 'user_id'])
            ->with('categories', 'user')
            ->news()
            ->paginate($request->input('per_page', 10));
    }

    public function stock(Request $request)
    {
        return News::filtredData($request, ['id', 'title', 'created_at', 'status', 'stock', 'user_id'])
            ->with('categories', 'user')
            ->stock()
            ->paginate($request->input('per_page', 10));
    }

    public function store(NewsCreateRequest $request)
    {
        $categories = $request->categories;

        if ($request->get('status', 'edit') != 'edit') {
            if (!Auth()->user()->can('publications.moderate')) {
                $request->merge([
                    'status' => 'edit'
                ]);
            }
        }

        $news = Auth()->user()->news()->create($request->only('title', 'description', 'url', 'status', 'stock'));
        $news->categories()->sync($categories);

        return [
            'id' => $news->id
        ];
    }

    public function show($id)
    {
        $news = News::with('user', 'categories')->findOrFail($id);
        $categories = $news->categories->keyBy('id')->keys();
        unset($news['categories']);
        $news['categories'] = $categories;

        return $news;
    }

    public function update(NewsCreateRequest $request, $id)
    {
        $categories = $request->categories;
        $news = News::findOrFail($id);

        if ($request->get('status', 'edit') != 'edit') {
            if (!Auth()->user()->can('publications.moderate')) {
                $request->merge([
                    'status' => 'edit'
                ]);
            }
        }

        $news->update($request->only('title', 'description', 'url', 'status'));
        $news->categories()->sync($categories);

        return [
            'id' => $news->id
        ];
    }

    public function delete($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return $this->successResponse();
    }
}
