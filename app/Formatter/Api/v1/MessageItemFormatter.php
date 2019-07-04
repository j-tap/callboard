<?php
/**
 * Created by black40x@yandex.ru
 * Date: 29/11/2018
 */

namespace App\Formatter\Api\v1;


use App\Formatter\Formatter;
use Illuminate\Pagination\Paginator;

class MessageItemFormatter extends Formatter
{
    public static function format($item)
    {
        return collect([
            'id' => $item->id,
            'date_create' => $item->created_at,

            'user' => [
                'id' => $item->user->id,
                'name' => $item->user->name,
                'org_name' => $item->user->organization->org_name,
              //  'logo' => $item->user->organization->logo
                'photo' => $item->user->photo

            ],
            'message' => $item->message,
            'status'  => $item->status
        ])->reject(function ($item) {
            return is_null($item);
        });
    }

    public static function formatPaginatorExtented(Paginator $paginator, $organization, $dealInfo)
    {
        $count = $paginator->count();
        $opponentUserId = $organization->owner->id;
        $hasMore = $paginator->hasMorePages();
        $items = $paginator->map(function($item, $key)  use($opponentUserId) {
           if($item->user->id === $opponentUserId){ // помечаем прочитанными толко сообщения от другого, а не свои
                $item->markAsReaded();
           }           
            return self::format($item);
        });

        return [
            'count' => $count,
            'hasMore' => $hasMore,
            'deal' => [
                'id' => $dealInfo['deal_id'],
                'name' => $dealInfo['deal_name'],
            ],
            'items' => $items,
            'organization' => [
                'id' => $organization->id,
                'name' => $organization->org_name,
                'logo' => $organization->logo,
            ],
            'user' => [
                'id' => $organization->owner->id,
                'name' => $organization->owner->name,
                'photo' => $organization->owner->photo,
            ]
        ];
    }

    public static function formatPaginator(Paginator $paginator) {}
}