<?php
/**
 * Created by black40x@yandex.ru / info@yksoft.ru
 * Date: 30.07.18
 */

return [
    'cache_time' => env('CACHE_TIME', 30),

    'email' => [
        'noreply' => env('B2B_EMAIL_NOREPLY', 'noreply@tamtem.ru'),
        'callme' => env('B2B_EMAIL_CALLME', 'callme@tamtem.ru')
    ],

    'images' => [
        'resizeValMaxPx' => 1200
    ],

    'permissions' => [
        'kladr' => [
            'name' => 'Кладр',
            'slug' => 'kladr',
            'permissions' => [
                'show', 'create', 'edit', 'delete',
            ],
        ],
        'dealquestion' => [
            'name' => 'Вопросы к сделкам',
            'slug' => 'dealquestion',
            'permissions' => [
                'show', 'create', 'edit', 'delete',
            ],
        ],
        'legalforms' => [
            'name' => 'Правовые формы организаций',
            'slug' => 'legalforms',
            'permissions' => [
                'show', 'create', 'edit', 'delete',
            ],
        ],
        'categories' => [
            'name' => 'Рубрикатор',
            'slug' => 'categories',
            'permissions' => [
                'show', 'create', 'edit', 'delete',
            ],
        ],
        'clients' => [
            'name' => 'Организации',
            'slug' => 'clients',
            'permissions' => [
                'show', 'view', 'create', 'edit', 'delete', 'moderate',
            ],
        ],
        'users' => [
            'name' => 'Сотрудники',
            'slug' => 'users',
            'permissions' => [
                'show', 'create', 'edit', 'delete',
            ],
        ],
        'publications' => [
            'name' => 'Публикации',
            'slug' => 'publications',
            'permissions' => [
                'show', 'create', 'edit', 'delete', 'moderate',
            ],
        ],
        'feedback' => [
            'name' => 'Обратная связь',
            'slug' => 'feedback',
            'permissions' => [
                'show', 'edit', 'delete',
            ],
        ],
        'adservice' => [
            'name' => 'Платные услуги',
            'slug' => 'adservice',
            'permissions' => [
                'show', 'edit',
            ],
        ],
    ],

    'permissions_site' => [
        'site_deals' => [
            'name' => 'Сделки',
            'slug' => 'site_deals',
            'permissions' => [
                'create', 'edit',
            ],
        ],
        'site_dialogs' => [
            'name' => 'Диалоги',
            'slug' => 'site_dialogs',
            'permissions' => [
                'create', 'show', 'delete',
            ],
        ],
        'site_favorites' => [
            'name' => 'Избранное',
            'slug' => 'site_favorites',
            'permissions' => [
                'add', 'show', 'delete',
            ],
        ],
        'site_services' => [
            'name' => 'Платные услуги',
            'slug' => 'site_services',
            'permissions' => [
                'show', 'buy',
            ],
        ],
        'site_pro_analytics' => [
            'name' => 'PRO Аккаунт, аналитика',
            'slug' => 'site_pro_analytics',
            'permissions' => [
                'show',
            ],
        ],
        'site_pro_notifications' => [
            'name' => 'PRO Аккаунт, уведомления',
            'slug' => 'site_pro_notifications',
            'permissions' => [
                'show', 'create', 'delete'
            ],
        ],
        'site_pro_accounts' => [
            'name' => 'PRO Аккаунт, доп. аккаунты',
            'slug' => 'site_pro_accounts',
            'permissions' => [
                'show', 'create', 'delete'
            ],
        ],
    ],
];