<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\User\UserStoreRequest;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use App\Models\Org\Organization;
use App\Models\User;
use App\Notifications\SendMantisTicket;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    use ApiControllerTrait;

    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        return User::filtredData($request)
            ->administrators()
            ->paginate($request->input('per_page', 10));
    }

    public function clients(Request $request)
    {
        return User::filtredData($request)
            ->workers()->with('organization')
            ->paginate($request->input('per_page', 10));
    }

    public function store(UserStoreRequest $request)
    {
        $user = new User();
        $user->name = $request->user['name'];
        $user->password = Hash::make($request->user['password']);
        $user->email = $request->user['email'];
        $user->role = $request->user['role'];
        $user->status = $request->user['status'];
        $user->unique_id = UsersController::generateUniqueUserIdNumber();
        $user->save();

        // Permissions
        $userPermissions = $request->extractPermission();

        $user->syncPermissions($userPermissions);

        return [
            'user_id' => $user->id
        ];
    }

    public function show($id)
    {
        $user = User::with('organization')->findOrFail($id);

        if ($user->role == User::ROLE_ADMINISTRATOR || $user->role == User::ROLE_MODERATOR) {
            $permissions = collect($user->getPermissionsStruct())
                ->only(collect(config('b2b.permissions'))->keys());
        } else {
            if ($user->organization->org_type == Organization::ORG_TYPE_SELLER) {
                $permissions = collect($user->getPermissionsStruct())
                    ->only(collect(config('b2b.permissions_site'))->keys());
            } else $permissions = null;
        }

        return [
            'user' => $user,
            'permissions' => $permissions
        ];
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $updateUser = $request->user;
        // Password
        if (isset($updateUser['password'])) {
            $updateUser['password'] = Hash::make($updateUser['password']);
        }

        $user->update($updateUser);

        // Permissions
        $userPermissions = $request->extractPermission();

        $user->syncPermissions($userPermissions);

        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $this->successResponse();
    }


    public static function generateUniqueUserIdNumber() {
        
        $number = mt_rand(1000000, 9999999); // better than rand()

        if (self::barcodeNumberExists($number)) {
            return self::generateUniqueUserIdNumber();
        }
 
        return $number;
    }
    
    public static function barcodeNumberExists($number) {
        return User::whereUniqueId($number)->exists();
    }

    public function sendMantisTicket (Request $request) {


        $user=User::find($request->id);
        $user->notify(new SendMantisTicket($request->text_body, $request->title));
    }
}
