<?php

namespace App\Repositories;

/**
 * Created by black40x@yandex.ru / info@yksoft.ru
 * Date: 30.07.18
 */

use App\Classes\Business\WorkTime;
use App\Models\Org\Organization;
use Hash;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Mockery\Exception;
use DB;
use App\Http\Controllers\Admin\UsersController;

class OrganizationRepository
{

    public static function createOrganization(Request $request, $checkAdmin = false)
    {

        try {
            $user = new User();
            $user->name =  $request->name ;
            $user->password = Hash::make($request->password);
            $user->email = mb_strtolower ($request->email);
            $user->role = User::ROLE_CLIENT;
            $user->phone = $request->phone;
            $user->unique_id = UsersController::generateUniqueUserIdNumber();
            $user->save();

            // Check admin/moderator permission for set status
            if ($checkAdmin) {
                if ($request->get('org_status', 'register') != 'register') {
                    if (!Auth()->user()->can('clients.moderate')) {
                        $request->merge([
                            'org_status' => 'register'
                        ]);
                    }
                }
            }

            $organization = $request->organization;
            if($organization === null) { // MVP версия , без заполнения организации
                $organization = $user->company()->create();
            }
            else{
                $organization = $user->company()->create($request->organization);
            }

            $user->organization()->associate($organization);  // Этот метод обновит отношения belongsTo() и установит внешний ключ на дочерней модели, в частности owner_id = users.id
            $user->save();

            // start permissions
           // if ($organization->org_type == Organization::ORG_TYPE_SELLER) { //закомментил, ибо в MVP логически 1 тип организации
                $permissions = config('b2b.permissions_site');
                $userPermissions = [];
                foreach ($permissions as $category) {
                    $slug = $category['slug'];
                    foreach ($category['permissions'] as $permission) {
                        $userPermissions[] = $slug . '.' . $permission;
                    }
                }
                $user->syncPermissions($userPermissions);
           // }
            // end permissions

            $user->notify(new \App\Notifications\UserRegisterConfirmation());
     //       $organization->notify(new \App\Notifications\OrganizationRegisterComplete());  //закомментил, ибо в MVP не надо слать в базу создание при регистрации

      //      dispatch((new \App\Jobs\Geo\GeoCodeOrganizationAddress($organization))->onQueue('geo')); //закомментил, ибо в MVP при регистрации не заполняем гео поля ,и значит не надо проверять гео

            return $user;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function createOrganizationWorker(Organization $organization, $name, $password, $email)
    {
        $user = new User();
        $user->name = $name;
        $user->password = Hash::make($password);
        $user->email = $email;
        $user->role = User::ROLE_CLIENT_WORKER;
        $user->organization()->associate($organization); // Этот метод бновит отношения belongsTo() и установит внешний ключ на дочерней модели, в частности owner_id = users.id
        $user->save();

        $user->notify(new \App\Notifications\UserRegisterConfirmation());

        return $user;
    }

    public static function getOrganization()
    {
        $query = Organization::select('organizations.*');

        if ($user = Auth::guard('api')->user()) {
            $query->leftJoin('user_favorites', function ($join) use ($user) {
                $join->on('user_favorites.favorite_id', '=', 'organizations.id')
                    ->on(DB::raw('user_favorites.organization_id'), DB::raw('='),DB::raw("'".$user->organization_id."'"));
            });

            $query->addSelect(['user_favorites.favorite_id as favorite']);
        }

        return $query->with('categories', 'stores', 'offices', 'city.region.country');
    }
}