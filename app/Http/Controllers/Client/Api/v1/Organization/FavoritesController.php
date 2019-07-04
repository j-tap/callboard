<?php

namespace App\Http\Controllers\Client\Api\v1\Organization;

use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Formatter\Api\v1\OrganizationItemFormatter;
use Auth;

class FavoritesController extends Controller
{
    use ApiControllerTrait;

    public function favorites()
    {
        return $this->successResponse(
            OrganizationItemFormatter::formatPaginator(
                Auth::guard('api')->user()->organization->favorites()
                    ->with('categories', 'legalForm', 'stores', 'offices', 'city.region.country')
                    ->approve()
                    ->simplePaginate(15)
            , function($item) {
                $item['favorite'] = true;
                return $item;
            })
        );
    }

    public function add($organization)
    {
        if ($organization == Auth::guard('api')->user()->organization->id)
            return $this->errorResponse();

        if (!Auth::guard('api')->user()->organization->favorites()->find($organization)) {
            Auth::guard('api')->user()->organization->favorites()->attach($organization);
        }

        return $this->successResponse();
    }

    public function delete($organization)
    {
        if (Auth::guard('api')->user()->organization->favorites()->find($organization)) {
            Auth::guard('api')->user()->organization->favorites()->detach($organization);
        }

        return $this->successResponse();
    }

}
