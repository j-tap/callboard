<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * getNullIsStringNullLetters - если строка содержит текстом "null", то возвращаем значение типа null
     *
     * @param  mixed $str
     *
     * @return void
     */
    public function getNullIsStringNullLetters( $str)
    {
        return (mb_strtolower($str) === "null") ? null : $str;
    }
}
