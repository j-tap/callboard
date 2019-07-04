<?php

namespace App\Http\Controllers\Client\Api\v1\Organization;

use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class NotificationsController extends Controller
{

    use ApiControllerTrait;

    public function notifications(Request $request)
    {
        $notifications = Auth::guard('api')->user()->organization->notifications()->simplePaginate(15);

        return $this->successResponse(
            [
                'count' => $notifications->count(),
                'hasMore' => $notifications->hasMorePages(),
                'items' => collect($notifications->items())->map(function($item, $key) {
                    $struct = json_decode($item->props, true);
                    return [
                        'id' => $item->id,
                        'date' => $item->created_at,
                        'message' => __($struct['message'], isset($struct['props']) ? $struct['props'] : [])
                    ];
                }),
            ]
        );
    }

}
