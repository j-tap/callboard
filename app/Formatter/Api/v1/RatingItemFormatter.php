<?php
/**
 * Created by black40x@yandex.ru
 * Date: 11.10.2018
 */

namespace App\Formatter\Api\v1;


use App\Formatter\Formatter;
use Illuminate\Pagination\Paginator;

class RatingItemFormatter extends Formatter
{
    public static function format($item)
    {
        return collect([
            'id' => $item->id,
            'rate' => $item->rate,
            'comment' => $item->comment,
            'sender' => [
                'id' => $item->sender->id,
            ],
        ])->reject(function ($item) {
            return is_null($item);
        });
    }

    public static function formatPaginator(Paginator $paginator)
    {
        $count = $paginator->count();
        $hasMore = $paginator->hasMorePages();
        $items = $paginator->map(function($item, $key) {
            return self::format($item);
        });

        return [
            'count' => $count,
            'hasMore' => $hasMore,
            'items' => $items,
        ];
    }
}