<?php

use Illuminate\Database\Seeder;
use App\Models\Payment\Subscription;
use Carbon\Carbon;

class LastSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * =======================  ТАРИФЫ  =====================================================
         * 
         */
        
        $allInId = Subscription::updateOrCreate(
            ['slug' => Subscription::SUBSCRIPTION_PAYMENT_ALL_IN],
            [  
                'name' => 'Все включено 30 дней', 
                'slug' => Subscription::SUBSCRIPTION_PAYMENT_ALL_IN, 
                'description' => '1. Размещение неограниченного количества объявлений. 2. Просмотр неограниченного количества контактных данных всех категорий. 3. Автоматическая система уведомления по заявкам в вашей категории.',
                'started_at' => Carbon::now(),
                'duration_days' => 30,
                'status' => Subscription::SUBSCRIPTION_STATUS_ACTIVE,
                'cost' => 3900,
                'type' => Subscription::SUBSCRIPTION_TYPE_TARIFF
           ]
        );
    
        $allInId = $allInId->id;

        $curTariff = Subscription::updateOrCreate(
            ['slug' => Subscription::SUBSCRIPTION_PAYMENT_ALL_IN_3_MONTHS],
            [  
                'name' => 'Все включено 90 дней', 
                'slug' => Subscription::SUBSCRIPTION_PAYMENT_ALL_IN_3_MONTHS, 
                'description' => '1. Размещение неограниченного количества объявлений. 2. Просмотр неограниченного количества контактных данных всех категорий. 3. Автоматическая система уведомления по заявкам в вашей категории.',
                'started_at' => Carbon::now(),
                'duration_days' => 90,
                'status' => Subscription::SUBSCRIPTION_STATUS_ACTIVE,
                'cost' => 9900,
                'type' => Subscription::SUBSCRIPTION_TYPE_TARIFF,
                'parent_id' => $allInId
           ]
        );

        $curTariff = Subscription::updateOrCreate(
            ['slug' => Subscription::SUBSCRIPTION_PAYMENT_ALL_IN_6_MONTHS],
            [  
                'name' => 'Все включено 180 дней', 
                'slug' => Subscription::SUBSCRIPTION_PAYMENT_ALL_IN_6_MONTHS, 
                'description' => '1. Размещение неограниченного количества объявлений. 2. Просмотр неограниченного количества контактных данных всех категорий. 3. Автоматическая система уведомления по заявкам в вашей категории.',
                'started_at' => Carbon::now(),
                'duration_days' => 180,
                'status' => Subscription::SUBSCRIPTION_STATUS_ACTIVE,
                'cost' => 19900,
                'type' => Subscription::SUBSCRIPTION_TYPE_TARIFF,
                'parent_id' => $allInId
           ]
        );

        $curTariff = Subscription::updateOrCreate(
            ['slug' => Subscription::SUBSCRIPTION_PAYMENT_ALL_IN_3_DAYS],
            [  
                'name' => 'Все включено на 3 дня', 
                'slug' => Subscription::SUBSCRIPTION_PAYMENT_ALL_IN_3_DAYS, 
                'description' => 'Вам доступен весь платный функционал в пакете  "Все включено 1 месяц"',
                'started_at' => Carbon::now(),
                'duration_days' => 3,
                'status' => Subscription::SUBSCRIPTION_STATUS_ACTIVE,
                'cost' => 0,
                'type' => Subscription::SUBSCRIPTION_TYPE_TARIFF,
                'parent_id' => $allInId
           ]
        );


         /**
         * =======================  УСЛУГИ  =====================================================
         * 
         */
        $curService = Subscription::updateOrCreate(
            ['slug' => Subscription::SUBSCRIPTION_PAYMENT_ONCE_DEAL_SELL],
            [  
                'name' => 'Разместить одно объявление на 30 дней', 
                'slug' => Subscription::SUBSCRIPTION_PAYMENT_ONCE_DEAL_SELL, 
                'description' => 'Оплата за размещение одного объявления о продаже вашего товара',
                'started_at' => Carbon::now(),
                'duration_days' => 30,
                'status' => Subscription::SUBSCRIPTION_STATUS_ACTIVE,
                'cost' => 290,
                'type' => Subscription::SUBSCRIPTION_TYPE_SERVICE,
           ]
        );

        $curService = Subscription::updateOrCreate(
            ['slug' => Subscription::SUBSCRIPTION_PAYMENT_ONCE_DEAL_BUY_GET_CONTACTS],
            [  
                'name' => 'Получить контакты пользователя', 
                'slug' => Subscription::SUBSCRIPTION_PAYMENT_ONCE_DEAL_BUY_GET_CONTACTS, 
                'description' => 'Оплата за просмотр контактных данных пользователя, подавшего заявку на покупку товара',
                'started_at' => Carbon::now(),
                'duration_days' => 0,
                'status' => Subscription::SUBSCRIPTION_STATUS_ACTIVE,
                'cost' => 290,
                'type' => Subscription::SUBSCRIPTION_TYPE_SERVICE,
           ]
        );

        $curService = Subscription::updateOrCreate(
            ['slug' => Subscription::SUBSCRIPTION_PAYMENT_ALWAYS_DEAL_BUY_MAIL_NOTIFICATION],
            [  
                'name' => 'Получать уведомления по почте заявки о продаже', 
                'slug' => Subscription::SUBSCRIPTION_PAYMENT_ALWAYS_DEAL_BUY_MAIL_NOTIFICATION, 
                'description' => 'Оплата, для получения уведомлений по почте о новой заявке-продаже, которая в той же категории, что и момпания подписчика',
                'started_at' => Carbon::now(),
                'duration_days' => 0,
                'status' => Subscription::SUBSCRIPTION_STATUS_ACTIVE,
                'cost' => 0,
                'type' => Subscription::SUBSCRIPTION_TYPE_SERVICE,
           ]
        );    

    }
}
