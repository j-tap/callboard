<?php
/**
 * Created by black40x@yandex.ru
 * Date: 24/10/2018
 */

namespace App\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class NotFoundException extends HttpException
{

    public function __construct($message = null)
    {
        $message = ($message === null ) ? 'Not found.' :  $message;
        parent::__construct(404, $message, null, [], 0);
    }

}