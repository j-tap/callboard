<?php

use Illuminate\Database\Seeder;

class AdSErviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\AdService::create(['name' => 'Дополнительное участие в сделке', 'slug' => 'ad1', 'days' => 1, 'cost' => 300]);
        \App\Models\AdService::create(['name' => 'Дополнительное размещение новости', 'slug' => 'ad2', 'days' => 1, 'cost' => 1000]);
        \App\Models\AdService::create(['name' => 'Размещение акций', 'slug' => 'ad3', 'days' => 1, 'cost' => 1000]);
        \App\Models\AdService::create(['name' => 'Доступ к быстрым сделкам', 'slug' => 'ad4', 'days' => 1, 'cost' => 1000]);
        \App\Models\AdService::create(['name' => 'Про аккаунт', 'slug' => 'ad5', 'days' => 1, 'cost' => 1000]);
    }
}
