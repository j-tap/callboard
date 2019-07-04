<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Client\Api\v1\PaymentServicesController;
use App\Traits\ModelFileUpload;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment\Subscription;
use App\Models\Payment\UserSubscription;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\CallMeMail;

use Hash;
use Auth;
use Cookie;

class ClientController extends Controller
{

    use ModelFileUpload;
    use ApiControllerTrait;

    public function index(Request $request)
    {

       $isviewedCookieName = 'isviewed';
       $isviewed = $request->cookie($isviewedCookieName);

       // если страница с лендосом была просмотрена, то есть куки и эту страницу не показываем
       if($isviewed){
            return view('client.layouts.spa');
       }
       else{
         //   Cookie::queue($isviewedCookieName, 'true', 2628000, true,  env('APP_URL', 'tamtem.ru'));
            Cookie::queue($isviewedCookieName, 'true', 2628000, "/");
            return view('client.layouts.about');
       }
      
    }

    public function about(Request $request)
    {

            return view('client.layouts.about');

    }

    /**
     *  Подтверждение регистрации email
     * 
     * registerConfirm
     *
     * @param  mixed $request
     * @param  mixed $token
     *
     * @return void
     */
    public function registerConfirm(Request $request, $token)
    {
        $user = User::where('register_confirm_token', $token)->first();
        if ($user) {
            $user->status = User::USER_STATUS_APPROVE;
            $user->register_confirm_token = null;
            $user->save();

			// дадим при подтверждении юзеру бесплатную подписку
            $paymentService = Subscription::getServiceFromSlug(Subscription::SUBSCRIPTION_PAYMENT_ALL_IN_3_DAYS);
            if($paymentService){
                    (new PaymentServicesController())->newUserSubscription($paymentService->id, $user->id, null , $paymentService->name);
            }
        }
        else{
            return redirect('/about');
        }
        return redirect('/success-email');
    }

    public function passwordResetConfirm(Request $request, $token)
    {
        try{
            $user = User::where('reset_password_token', $token)->get()->first();
            $newPassword = base64_decode($token);
            if ($user) {
                $user->password = $newPassword;
                $user->reset_password_token = null;
                $user->save();
            }
            else{
                return response()->json(['result' => false, 'error' => 'Reset password token not valid']);
            }
        }
        catch(\Exception $e){
            return response()->json(['result' => false, 'error' => $e]);
        }
        
        return redirect('/success-reset');
    }

    // Юзер  забыл пароль, и указал мыло для его сброса
    public function passwordResetSend(Request $request)
    {

        $v = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
        ]);

        if ($v->fails())
        {
            return response()->json(['result' => false, 'error' => $v->errors()]);
        }
       
        $email = $request->email;
        $new_password = str_random(6);
        $token = base64_encode( Hash::make($new_password)); 

        $user = User::where('email', $email)->get()->first();
        $user->reset_password_token = $token;
        $user->save();

        $user->notify(new \App\Notifications\UserResetPassword( $token,  $new_password));
        return response()->json(['result' => true]);
       // return redirect('/');
    }

      // Юзер  шлет повторное письмо для подтверждения емейл
      public function repeateRegisterMailSend(Request $request)
      {
  
          $v = Validator::make($request->all(), [
              'email' => 'required|exists:users,email',
          ]);
  
          if ($v->fails())
          {
              return response()->json(['result' => false, 'error' => $v->errors()]);
          }
         
          $email = $request->email;

  
          $user = User::where('email', $email)->get()->first();

          if($user->status !== User::USER_STATUS_REGISTRED){
                return $this->errorResponse();
          }
          $user->notify(new \App\Notifications\UserRegisterConfirmation());

          return $this->successResponse();

      }

    // ЛК юзера - обновление данных
    public function update(Request $request)
    {
        try{

            $user = Auth::guard('api')->user();

            $input = $request->all();
            $max_size = (int)ini_get('upload_max_filesize') * 1000;
            $v = Validator::make($request->all(), [
                'name' => 'sometimes|min:4|max:190',
                'phone' => 'required|regex:/(^(\d+)$)/u|min:10|max:10',
                'photo' => 'sometimes|mimes:jpeg,bmp,png|max:' . $max_size,
            ]);
        
            if ($v->fails())
            {
                return response()->json(['result' => false, 'error' => $v->errors()]);
            }
            
            $oldPhotoPAth = $user->photo ;
            if(isset( $input['name']))  $user->name = $input['name'];
            if(isset( $input['phone'])) $user->phone = $input['phone'];

            if(isset( $input['photo'])) {
                if($user->photo !==  null){
                    $this->deleteImageFromStore($oldPhotoPAth); 
                }
                $user->photo = null;
                $arrToImportTable = $this->uploadImageToStore( $input['photo'], 'users/' . $user->id . '/lk/images', config('b2b.images.resizeValMaxPx'));
                if(isset( $arrToImportTable['file_full_path'])){
                    $user->photo  = $arrToImportTable['file_full_path'];
                }
            }

            $user->save();

            return $this->successResponse($user);
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
        
    }
  
    public function deletePhoto(Request $request)
    {
        try{

            $user = Auth::guard('api')->user();
            $path = $request->input('path');

            if($user->photo !== $path or $user->photo === null){
                return $this->errorResponse("Вы не можете удалять чужое фото!");
            }
            
            // $v = Validator::make($request->all(), [
            //     'path' => 'required|email|unique:users,photo',
            // ]);
        
            // if ($v->fails())
            // {
            //     return response()->json(['result' => false, 'error' => $v->errors()]);
            // }

            if(!$this->deleteImageFromStore($path)){
                return $this->errorResponse("Ошибка удаления файла");
            }

            $user->photo = null;
            $user->save();

            return $this->successResponse();
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
		}

    }

    
    /**
     * callMe - шлет письмо , когда заказан обратный звонок клиентом
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function callMe(Request $request)
    {
        try{

            $v = Validator::make($request->all(), [
                'phone' => 'required|regex:/(^(\d+)$)/u|min:10|max:10',
            ]);
        
            if ($v->fails())
            {
                return response()->json(['result' => false, 'error' => $v->errors()]);
            }

            Mail::to(config('b2b.email.callme'))->send(new CallMeMail( '+7' . $request->get('phone')));

            return $this->successResponse('Письмо в службу поддержки успешно отправлено, ожидайте звонок в ближайшее время');
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
		}

    }
}
