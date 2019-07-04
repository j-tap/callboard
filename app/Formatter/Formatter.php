<?php
/**
 * Created by black40x@yandex.ru
 * Date: 11.10.2018
 */

namespace App\Formatter;

use Illuminate\Pagination\Paginator;

abstract class Formatter
{
    // ToDo - Maybe best way is Resources Eloquent ?

    public static function format($item) {}
    public static function formatPaginator(Paginator $paginator) {}
}