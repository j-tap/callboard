<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = config('b2b.permissions');

        foreach ($permissions as $category) {
            $slug = $category['slug'];
            foreach ($category['permissions'] as $permission) {
                try {
                    Permission::create(['name' => $slug.'.'.$permission]);
                } catch (Exception $e) {
                }
            }
        }

        $permissions = config('b2b.permissions_site');

        foreach ($permissions as $category) {
            $slug = $category['slug'];
            foreach ($category['permissions'] as $permission) {
                try {
                    Permission::create(['name' => $slug.'.'.$permission]);
                } catch (Exception $e) {
                }
            }
        }
    }
}
