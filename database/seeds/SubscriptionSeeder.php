<?php

use Illuminate\Database\Seeder;
use App\Models\Payment\Subscription;
use Carbon\Carbon;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Оплата про-аккаунта, включает в себя все пакеты
        $allInId = Subscription::create([  
                                'name' => 'Pro аккаунт', 
                                'slug' => 'payment_all_in', 
                                'description' => 'Оплата про-аккаунта, включает в себя все пакеты. Тариф - все включено',
                                'started_at' => Carbon::now(),
                                'duration_days' => 0,
                                'status' => Subscription::SUBSCRIPTION_STATUS_ACTIVE,
                                'cost' => 1000
        ]);
        $allInId = $allInId->id;
        // Оплата размещения заявки о продаже
        Subscription::create([  
                                'name' => 'Разместить заявку о продаже', 
                                'slug' => 'payment_once_deal_sell', 
                                'description' => 'Оплата размещения заявки о продаже',
                                'started_at' => Carbon::now(),
                                'duration_days' => 30, // инфо для юзера, купившего тариф (столько дней он будет у него действовать)
                                'status' => Subscription::SUBSCRIPTION_STATUS_ACTIVE,
                                'cost' => 290,
                                'parent_id' => $allInId
        ]);
        // Оплата для получения уведомлений по почте о новой заявке-продаже, которая в той же категории, что и момпания подписчика
        Subscription::create([  
                                'name' => 'Получать уведомления по почте заявки о продаже', 
                                'slug' => 'payment_always_deal_buy_mail_notification', 
                                'description' => 'Оплата, для получения уведомлений по почте о новой заявке-продаже, которая в той же категории, что и момпания подписчика',
                                'started_at' => Carbon::now(),
                                'duration_days' => 0,
                                'status' => Subscription::SUBSCRIPTION_STATUS_ACTIVE,
                                'cost' => 0,
                                'parent_id' => $allInId
        ]);
        // Оплата для получения контактов пользователя, который разместил заявку о покупке - вопль
        Subscription::create([  
                                'name' => 'Получить контакты пользователя заявки о продаже', 
                                'slug' => 'payment_once_deal_buy_get_contacts', 
                                'description' => 'Оплата для получения контактов пользователя, который разместил заявку о покупке - вопль',
                                'started_at' => Carbon::now(),
                                'duration_days' => 0,
                                'status' => Subscription::SUBSCRIPTION_STATUS_ACTIVE,
                                'cost' => 290,
                                'parent_id' => $allInId
        ]);

    }
}
