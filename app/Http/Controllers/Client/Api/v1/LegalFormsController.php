<?php

namespace App\Http\Controllers\Client\Api\v1;

use App\Models\Org\OrganizationLegalForm;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cache;

class LegalFormsController extends Controller
{

    use ApiControllerTrait;

    public function getForms()
    {
        return $this->successResponse(Cache::remember('api.legal.forms', config('b2b.cache_time'), function() {
            return OrganizationLegalForm::all(['id', 'name', 'short_name']);
        }));
    }

}
