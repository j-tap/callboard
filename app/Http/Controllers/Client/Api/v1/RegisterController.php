<?php

namespace App\Http\Controllers\Client\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Api\v1\Register\RegisterCustomerRequest;
use App\Http\Requests\Client\Api\v1\Register\RegisterSupplierRequest;
use App\Http\Requests\Client\Api\v1\Register\RegisterUserRequest;
use App\Repositories\OrganizationRepository;
use App\Traits\ApiControllerTrait;
use Auth;

class RegisterController extends Controller
{
    use ApiControllerTrait;

    // todo удалить при чистке
    // public function registerCustomer(RegisterCustomerRequest $request)
    // {
    //     if (OrganizationRepository::createOrganization($request))
    //         return $this->successResponse();

    //     return $this->errorResponse();
    // }

    // public function registerSupplier(RegisterSupplierRequest $request)
    // {
    //     if (OrganizationRepository::createOrganization($request))
    //         return $this->successResponse();

    //     return $this->errorResponse();
    // }


    public function registerUser(RegisterUserRequest $request)
    {
        if (OrganizationRepository::createOrganization($request))
            return $this->successResponse();

        return $this->errorResponse();
    }

}
