<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Org\OrganizationDeal;
use App\Formatter\Api\v1\DealsItemFormatter;

class DealsBuyMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    private $message;
    private $user;
    private $deal;

    public function __construct($message, $user, $deal) 
    {
        $this->message = $message;
        $this->user = $user;
        $this->deal = $deal; 
    }

    public function broadcastOn()
    {
       // return new PrivateChannel('deals.buy.public' );
        return new Channel('deals.buy.public'); // публичный канал
    }

    public function broadcastWhen()
    {
        return $this->deal->type_deal === OrganizationDeal::DEAL_TYPE_BUY;
    }

    public function broadcastAs()
    {
        return 'dealsBuy';
    }

    public function broadcastWith()
    {
        $id = $this->deal->id;
		if (!$deal = OrganizationDeal::with(['organization', 'members', 'categories', 'cities', 'user', 'questions'])->find($id))
			throw new \App\Exceptions\NotFoundException();

        $dealFormat = DealsItemFormatter::format($deal);        
        
        return [
            'message' => $this->message,
            'deal' => [
                $dealFormat
            ],
            // 'user' => [
            //     'id' => $this->deal->user_id,
            // ],
        ];
    }
}
