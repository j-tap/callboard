<?php

use Illuminate\Database\Seeder;
use App\Http\Controllers\Admin\UsersController;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = config('b2b.permissions');
        $userPermissions = [];

        $user = new App\Models\User();
        $user->name = 'admin';
        $user->password = Hash::make('admin');
        $user->email = 'admin@admin.com';
        $user->role = \App\Models\User::ROLE_ADMINISTRATOR;
        $user->status = \App\Models\User::USER_STATUS_APPROVE;
        $user->unique_id = UsersController::generateUniqueUserIdNumber();
        $user->save();

        foreach ($permissions as $category) {
            $slug = $category['slug'];
            foreach ($category['permissions'] as $permission) {
                $userPermissions[] = $slug . '.' . $permission;
            }
        }

        $user->syncPermissions($userPermissions);
    }
}
