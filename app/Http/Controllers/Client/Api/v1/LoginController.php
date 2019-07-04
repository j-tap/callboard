<?php

namespace App\Http\Controllers\Client\Api\v1;

use App\Formatter\Api\v1\OrganizationItemFormatter;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Auth;

class LoginController extends Controller
{

    use ApiControllerTrait;

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:5',
        ]);

        if(User::where('email', $request->get('email'))->exists()) {
            $user = User::where('email', $request->get('email'))->first();

            // не пускать забаненого
            if($user->banned()){
                response($this->errorResponse(['message' => "Отказано в доступе. Проверьте правильность ввода E-mail и пароля."]), 401);
            }
            
            $auth = Hash::check($request->get('password'), $user->password);

            if ($user && $user->status === User::USER_STATUS_REGISTRED) {
                return $this->errorResponse(['error_code' => User::USER_STATUS_REGISTRED, 
                                            'message' => "Вы не прошли процедуру подтверждения адреса своей электронной почты. Перейдите по ссылке в присланном вам письме или отправьте такое письмо повторно"]);
            }

            if ($user && ($user->role != User::ROLE_CLIENT && $user->role != User::ROLE_CLIENT_WORKER && $user->role != User::ROLE_ADMINISTRATOR)
                || $user->status != User::USER_STATUS_APPROVE) {
                return $this->errorResponse(['message' => "Отказано в доступе. Этот пользователь не имеет право входа для размещения заявок."]);
            }

            if($user && $auth) {
                $user->rollApiKey();
                return $this->successResponse([
                    'api_token' => $user->api_token,
                ]);
            }
        }

        return response($this->errorResponse(['message' => "Отказано в доступе. Проверьте правильность ввода E-mail и пароля."]), 401);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::guard('api')->user();

        $this->validate($request, [
            'password_confirmation' => 'required|min:6|max:32',
            'password' => 'required|min:6|max:32|confirmed:password_confirmation',
            'password_old' => 'required|min:6|max:32'
        ]);

        if (!$oldPassword = Hash::check($request->get('password_old'), $user->password)) {
            return response()->json($this->errorResponse([
                'errors' => ['password_old' => ['Вы не правильно ввели старый пароль.']]
            ]), 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return $this->successResponse();
    }

    public function profile()
    {
        $profile = Auth::guard('api')->user();

        $response = [
            'profile' => [
                'id' => $profile->id,
                'email' => $profile->email,
                'name' => $profile->name,
                'role' => $profile->role,
                'status' => $profile->status,
                'is_org_created' => $profile->is_org_created,
                'unique_id' => $profile->unique_id,
                'phone' => $profile->phone,
                'photo' => $profile->photo,
                'ballance' => $profile->ballance,
            ],
            'permissions' => collect($profile->getPermissionsStruct())
                                    ->only(collect(config('b2b.permissions_site'))->keys()),

            'active_payment_subscriptions' => $profile->subscriptionExtendedToLKFromSlug(),
            // 'active_payment_subscriptions' => $profile->subscriptionExtendedToLKFromSlug('all'),
        ];

        if( $profile->is_org_created){
            $response['company'] = OrganizationItemFormatter::format($profile->organization()
                                            ->with('city.region.country', 'categories','offices','stores')->first());
        }

        return $this->successResponse(
            $response
        );
    }

    public function getProfileFromId($id)
    {

        $profile = User::findOrFail($id);

        $response = [
            'profile' => [
                'id' => $profile->id,
                'email' => $profile->email,
                'name'  => $profile->name,
                'phone' => $profile->phone,
                'photo' => $profile->photo,
            ],
        ];

        if( $profile->is_org_created){
            $response['company'] = OrganizationItemFormatter::formatPublicProfile($profile->organization()
                                            ->with('city.region.country', 'categories','offices','stores')->first());
        }

        return $this->successResponse(
            $response
        );
    }

}
