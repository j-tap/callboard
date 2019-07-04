<?php

namespace App\Http\Controllers\Client\Api\v1;

use App\Models\News;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Formatter\Api\v1\NewsItemFormatter;
use App\Repositories\Filters\FilterNewsRepository;

class NewsController extends Controller
{

    use ApiControllerTrait;

    public function news(Request $request)
    {
        return $this->successResponse(
            NewsItemFormatter::formatPaginator(
                FilterNewsRepository::siteNews(
                    array_filter(explode(',', $request->get('category')))
                )->news()->approve()->simplePaginate(15)
            )
        );
    }

    public function newsShow($id)
    {
        if (!$news = News::where('url', $id)->first())
            throw new \App\Exceptions\NotFoundException();

        return $this->successResponse(
            NewsItemFormatter::format($news)
        );
    }

}
