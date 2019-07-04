<?php

namespace App\Http\Controllers\Client\Api\v1\Organization;

use App\Formatter\Api\v1\NewsItemFormatter;
use App\Http\Requests\Client\Api\v1\Organization\NewsStoreRequest;
use App\Models\News;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class OrganizationNewsController extends Controller
{
    use ApiControllerTrait;

    public function news()
    {
        return $this->successResponse(
            NewsItemFormatter::formatPaginator(
                Auth::guard('api')->user()->organization
                    ->news()
                    ->news()
                    ->with('user.organization', 'categories')
                    ->simplePaginate(10)
            )
        );
    }

    public function stocks()
    {
        return $this->successResponse(
            NewsItemFormatter::formatPaginator(
                Auth::guard('api')->user()->organization
                    ->news()
                    ->stock()
                    ->with('user.organization', 'categories')
                    ->simplePaginate(10)
            )
        );
    }

    public function newsStore(NewsStoreRequest $request)
    {
        $news = Auth::guard('api')->user()->news()->create(
            $request->all(['title', 'description', 'url', $request->get('stock', '0')])
        );

        $news->categories()->sync($request->categories);
        $news->uploadImages($request);

        return $this->successResponse([
            'id' => $news->id
        ]);
    }

    public function newsUpdate(NewsStoreRequest $request, $news)
    {
        $news = Auth::guard('api')->user()->organization->news()->find($news);

        $news->update(
            $request->all(['title', 'description', 'url'])
        );
        $news->categories()->sync($request->categories);

        return $this->successResponse();
    }

    public function newsDelete(Request $request, $news)
    {
        if (!$news = Auth::guard('api')->user()->organization->news()->find($news))
            throw new \App\Exceptions\NotFoundException();

        $news->delete();

        return $this->successResponse();
    }
}
