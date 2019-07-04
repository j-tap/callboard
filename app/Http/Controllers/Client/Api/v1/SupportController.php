<?php

namespace App\Http\Controllers\Client\Api\v1;

use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\SendMantisTicket;
class SupportController extends Controller
{
    use ApiControllerTrait;


    public function index(Request $request)
    {
        $user = Auth::guard('api')->user();

        if($request->data['form_type']==0){
            $theme='Техническая поддержка: '.$request->data['theme'];
        }else{
            $theme='Пожелания: '.$request->data['theme'];
        }




        if($user){
            $user = User::find($user->id);
            $text='';
            $text.='<p>'.$request->data['text'].'</p>';
            $text.='<p> <b>Телефон: </b>'.$user->phone.'</p>';
            $text.='<p> <b>E-mail: </b>'.$user->email.'</p>';
            $user->notify(new SendMantisTicket($text, $theme));
        }else{

            $text='';
            $text.='<p>'.$request->data['text'].'</p>';
            $text.='<p> <b>Телефон: </b>'.$request->data['phone'].'</p>';
            $text.='<p>  <b>E-mail: </b>'.$request->data['email'].'</p>';

            $user = User::find(1);
            $user->notify(new SendMantisTicket($text, $theme));
        }

        return $this->successResponse();
    }

}
