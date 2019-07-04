<?php
/**
 * Created by black40x@yandex.ru
 * Date: 07.10.2018
 */

namespace App\Traits;


trait ApiControllerTrait
{

    public function successResponse($data = null)
    {
        if (isset($data))
            return ['result' => true, 'data' => $data];

        return ['result' => true];
    }

    public function errorResponse($error = null)
    {
        if (isset($error))
            return ['result' => false, 'error' => $error];

        return ['result' => false];
    }

    public function paginateResponse($paginate)
    {
        if(!$paginate)
            return $this->errorResponse();

        return [
            'result' => true,
            'data' => [
                'count' => $paginate->count(),
                'hasMore' => $paginate->hasMorePages(),
                'items' => $paginate->items(),
            ],
        ];
    }
    
}