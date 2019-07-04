<?php

namespace App\Http\Controllers\Client\Api\v1;

use App\Formatter\Api\v1\DialogItemFormatter;
use App\Formatter\Api\v1\MessageItemFormatter;
use App\Models\Dialog;
use App\Models\Message;
use App\Models\Org\Organization;
use App\Models\Org\OrganizationDeal;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class DialogsController extends Controller
{

    use ApiControllerTrait;

    // mvp tamtem
	// все диалоги юзера  ======================================================
    public function dialogs(Request $request)
    {
        
        try{

            $user = Auth::guard('api')->user();
            $myOrg = $user->organization_id;
            $myUserId =  $user->id;
           // dd($user->organization->dialogs_all()->get()->toArray());
            $dialogs = $user->organization->dialogs_all()->select(['id', 'seller_id', 'buyer_id', 'deal_id', 'created_at'])
                                ->orderBy('updated_at', 'desc')
                                ->with('seller', 'buyer', 'deal', 'last_message');

            $formatPaginator = new DialogItemFormatter();
            
            return $this->successResponse($formatPaginator->formatPaginator($dialogs->simplePaginate(15), $myOrg, $myUserId));
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }

    }

    // mvp tamtem
	// кол-во не прочитанных сообщений во всех диалогах юзера ======================================================
    public function countunreaded(Request $request)
    {
        
        try{

            $user = Auth::guard('api')->user();
            $myOrg = $user->organization_id;
            $dialogs = $user->organization->dialogs_all()->get();
            $countUnreaded = 0;
          //  dd($dialogs);
            foreach($dialogs as $dialog){
                $countUnreaded += $dialog->unreaded_messages($user->id);
            }
                      
            return $this->successResponse($countUnreaded);
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }

    }

    // mvp tamtem
	// пометить сообщения прочитанными ======================================================
    public function markReaded(Request $request)
    {
        
        try{

            $user = Auth::guard('api')->user();
            $messageId = (int) $request->get("id", null);

            $message = Message::where("id", "=" , $messageId)->where("user_id", "<>", $user->id)->where("status" , "=" , Message::MESSAGE_STATUS_UNREADED)->first();
            //dd(["user_id"=> $user->id, "message" => $message]);
            if($message){
                $message ->markAsReaded();         
            }
          
            return $this->successResponse();
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }

    }

    // mvp tamtem
	// диалог по его ID  ======================================================
    public function dialog(Request $request, $id)
    {
        
        try{

            if (!$dialog = Dialog::find($id))
            throw new \App\Exceptions\NotFoundException();

            $user = Auth::guard('api')->user();
          
            if ($user->organization_id != $dialog->seller_id && $user->organization_id != $dialog->buyer_id)
                throw new \App\Exceptions\NotFoundException();

            if ($dialog->seller_id === $user->organization_id) {
                $organization = $dialog->buyer;
            } else
                $organization = $dialog->seller;

            $dealInfo = $dialog->deal()->select('id as deal_id', 'name as deal_name')->first()->toArray();

            $messages = $dialog->messages()->with('user.organization')->orderBy('created_at', 'desc')->simplePaginate(15);

            // foreach ( $messages as $key =>  $message) {
            //     # code...
            // }

         //   dd($messages->toArray());
            $ret = $this->successResponse(
                MessageItemFormatter::formatPaginatorExtented(
                    $messages, $organization, $dealInfo
                )
            );

            return $ret;
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }

    }

    // mvp tamtem
	// новый диалог  ======================================================
    public function newDialog(Request $request)
    {
        try{

            $user = Auth::guard('api')->user();

            $this->validate($request, [
         //       'member_id' => 'required|integer',
                'deal_id' => 'required|integer',
            ]);
    
            $deal_id    = $request->deal_id;
            $member_id  = $user->organization_id;
    
            // если нет такой сделки
            if (!$deal = OrganizationDeal::find($deal_id))
                return $this->errorResponse('Нет такой сделки');
    
            $org_to  = $deal->organization_id; // кому пишем
    
            // проверка, чтобы не писал, сам себе
            if($deal->user_id === $user->id ){
                return $this->errorResponse('Нельзя создать диалог с самим собой');
            }
    
            if (!$member = $deal->members()->where('organization_id', $member_id)->first()){
                //создаем участника сделки, по факту, просто заинтересованого, кто
                $deal->members()->attach($member_id);
            }
    
            $buyer_id   = null;
            $seller_id  = null ;
            // выясним, кто создатель диалога. покупатель или продавец
            if($deal->type_deal === OrganizationDeal::DEAL_TYPE_SELL){  // тот, кому мы пишем - продавец
                $buyer_id   = $user->organization_id;
                $seller_id  = $org_to ;
            }
            elseif($deal->type_deal === OrganizationDeal::DEAL_TYPE_BUY){ // покупка
                $buyer_id   = $org_to;
                $seller_id  = $user->organization_id ;
            }
            else{ // пока другого вида сделок нет, потому нафиг 
                return $this->errorResponse('Данный вид сделок не предусмотрен');
            }
    
            // создаем сам диалог
            // if (!$dialog = $user->organization->dialogs_buyer()->where('buyer_id', $user->organization->id)->where('seller_id', $request->member_id)->first()) {
            if (!$dialog = Dialog::where('deal_id', $deal_id )->where('buyer_id', $buyer_id)->where('seller_id', $seller_id)->first()) {
                $dialog = new Dialog();
                $dialog->seller_id = $seller_id;
                $dialog->buyer_id = $buyer_id;
                $dialog->deal_id = $deal_id ;
                $dialog->save();
            }
    
            return $this->successResponse([
                'id' => $dialog->id
            ]);
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }

    }

    // mvp tamtem
	// послать сообщение в диалог  ======================================================
    public function send(Request $request, $id)
    {
        try{

            if (!$dialog = Dialog::find($id)){
                return $this->errorResponse('Нет диалога с таким id');
            }

            $user = Auth::guard('api')->user();

            if ($user->organization_id != $dialog->seller_id && $user->organization_id != $dialog->buyer_id){
                return $this->errorResponse('Вас нет в этом диалоге');
            }

            $this->validate($request, [
                'message' => 'required|min:1|max:2048'
            ]);

            $message = $dialog->messages()->create([
                'user_id' => $user->id,
                'message' => trim($request->message)
            ]);

            $user->organization->notify(new \App\Notifications\OrganizationChatMessage($message, $user));

            return $this->successResponse();
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    
    }

    
    // mvp tamtem
	// удалить диалог  ======================================================
    public function delete(Request $request, $id)
    {

        try{
            if (!$dialog = Dialog::find($id))
            throw new \App\Exceptions\NotFoundException();

            $user = Auth::guard('api')->user();

            if ($user->organization_id != $dialog->seller_id && $user->organization_id != $dialog->buyer_id)
                throw new \App\Exceptions\NotFoundException();

            $dialog->delete();

            return $this->successResponse();
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }

    }

}
