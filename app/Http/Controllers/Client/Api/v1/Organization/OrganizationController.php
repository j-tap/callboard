<?php

namespace App\Http\Controllers\Client\Api\v1\Organization;

use App\Formatter\Api\v1\NewsItemFormatter;
use App\Formatter\Api\v1\OrganizationItemFormatter;
use App\Formatter\Api\v1\RatingItemFormatter;
use App\Models\Org\Organization;
use App\Repositories\OrganizationRepository;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class OrganizationController extends Controller
{
    use ApiControllerTrait;

    // mvp-tamtem  инфа по указанной организации
    public function info(Request $request, $organization)
    {
        if (!$organization = OrganizationRepository::getOrganization($organization)->find($organization)) {
            return $this->errorResponse();
        }

        return $this->successResponse(
            OrganizationItemFormatter::format($organization)
        );
    }

    public function news($organization)
    {
        if (!$organization = Organization::find($organization))
            return $this->errorResponse();

        return $this->successResponse(
            NewsItemFormatter::formatPaginator($organization->news()->with('user.organization')->approve()->news()->simplePaginate(10))
        );
    }

    public function ratings($organization)
    {
        if (!$organization = Organization::find($organization))
            return $this->errorResponse();

        return $this->successResponse(
            RatingItemFormatter::formatPaginator($organization->ratings()->with('sender')->simplePaginate(10))
        );
    }

    public function stock($organization)
    {
        if (!$organization = Organization::find($organization))
            return $this->errorResponse();

        return $this->paginateResponse(
            $organization->news()->approve()->stock()->simplePaginate(10)
        );
    }

}
