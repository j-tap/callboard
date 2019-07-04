<?php
/**
 * Created by black40x@yandex.ru
 * Date: 29/11/2018
 */

namespace App\Formatter\Api\v1;


//use App\Formatter\Formatter;
use Illuminate\Pagination\Paginator;

class DialogItemFormatter
{
    
    public $myOrg = null;
    public $myUserId = null;

    public function format($item)
    {
        return collect([
            'id' => $item->id,
            'date_create' => $item->created_at,
            'date_update' => $item->updated_at,
            'last_message' => $item->last_message ? $item->last_message->message : null,
            'last_message_date' => $item->last_message ? $item->last_message->created_at : null,
            'deal' => [
                'id' => $item->deal->id,
                'name' => $item->deal->name,
            ],
            'organization' => ($item->seller->id !== $this->myOrg) ? [
                'id' => $item->seller->id,
                'name' => $item->seller->org_name,
                'logo' => $item->seller->logo,
            ] : [
                'id' => $item->buyer->id,
                'name' => $item->buyer->org_name,
                'logo' => $item->buyer->logo,
            ],
            'user' => ($item->seller->id !== $this->myOrg) ? [
                'id' => $item->seller->owner->id,
                'name' => $item->seller->owner->name,
                'photo' => $item->seller->owner->photo,
            ] : [
                'id' => $item->buyer->owner->id,
                'name' => $item->buyer->owner->name,
                'photo' => $item->buyer->owner->photo,
            ],
            'count_unreaded_messages' =>  $item->unreaded_messages($this->myUserId),
        ])->reject(function ($item) {
            return is_null($item);
        });
    }

    public function formatPaginator(Paginator $paginator, $myOrg = null, $myUserId = null)
    {
//dd( $paginator->toArray());
        $this->myOrg = $myOrg;
        $this->myUserId = $myUserId;
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