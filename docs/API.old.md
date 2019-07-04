#API b2b

Формат ответа от сервера имеет следующий вид:

    {
        result: Boolean,
        data: Object
    }
    
Ответы с пагинацией

    {
        result: true,
        data: {
            count: Integer,
            hasMore: Boolean,
            items: Array
        }
    }
    
Ответы которые проходят валидацию, в результате ошибки отдают код `422` и содержат массив `errors` с описанием ошибок.
Ответы требующие авторизацию в случае ошибки отдают код `411`.

####Составные сущности

#####Организация

    {
        id: Integer,
        owner_id: Integer,
        owner_first_name: String,
        owner_second_name: String,
        owner_middle_name: String,
        contact_phone: Integer,
        favorite: Boolean,
        rating: Float,
        organization: {
            type: 'supplier' or 'customer',
            inn: String,
            name: String,
            legal_form: String,
            legal_form_slug: String,
            director: String,
            address: String,
            address_legal: String,
            work_time: WorkTime,
            location: {
                lat: Float,
                lon: Float
            },
            site: Url,
            description: String,
            media: {
                logo: String,
                video: String,
                image_1: String,
                image_2: String,
                image_3: String,
            },
            city: {
                id: Integer,
                name: String
            },
            region: {
                id: Integer,
                name: String
            ],
            country: {
                id: Integer,
                name: String
            ],
            categories: ArrayOf {
                id: Integer,
                name: String,
            },
            stores: ArrayOf {
                id: Integer,
                address: String,
                location: {
                    lat: Float,
                    lon: Float
                }
            },
            offices: ArrayOf {
                id: Integer,
                address: String,
                location: {
                    lat: Float,
                    lon: Float
                }
            }
    }

#####Новость
    
    {
        id: Integer,
        date_create: Date,
        date_update: Date,
        title: String,
        description: String,
        shortdesc: String,
        url: String,
        media: {
            image_1: String,
            image_2: String,
            image_3: String,
        },
        organization: {
            id: Integer,
            name: String,
        },
        owner: {
            id: Integer,
            name: String,
        },
        city: {
            id: Integer,
            name: String,
        },
        region: {
            id: Integer,
            name: String,
        },
        country: {
            id: Integer,
            name: String,
        },
        categories: ArrayOf {
            id: Integer,
            name: String,
        },
    }
    
#####Сделка

    {
        id: Integer,
        date_create: Date,
        date_update: Date,
        name: String,
        description: String,
        pay_type_cash: Boolean,
        pay_type_noncash: Boolean,
        budget_from: Integer,
        budget_to: Integer,
        fast_deal: Boolean,
        favorite_only: Boolean,
        deadline_deal: Date,
        deadline_service: Date,
        question: String,
        finish: Boolean,
        winner: Organization,
        winner_id: Integer,
        organization: {
            id: Integer,
            name: String,
        },
        owner: {
            id: Integer,
            name: String,
        },
        categories: ArrayOf {
            id: Integer,
            name: String,
        },
        cities: ArrayOf {
            id: Integer,
            name: String,
        },
        questions: ArrayOf {
             id: Integer,
             name: String,
             question: String,
        },
        members: ArrayOf {
            organization: Organization,
            answers: ArrayOf {
                question: Integer/Null,
                answer: String
            }
        }
    }

#####Рейтинг

    {
        id: Integer,
        rate: Integer,
        comment: String,
        sender: {
            id: Integer,
        }
    }

#####Диалог

    {
        id: Integer,
        date_create: Date,
        date_update: Date,
        organization: {
            id: Integer,
            name: String,
        },
        message: String
    }
    
#####Сообщение

    {
        id: Integer,
        date_create: Date,
        owner: {
            id: Integer,
            name: String,
        },
        message: String
    }

####Авторизация

    [POST] /api/v1/login

| Field      | Required   |
| ---------- | ---------- |
| `password` | yes |
| `email`    | yes |
    
Возвращает `api_token`, который используется для запросов требующих авторизацию. 
Указывается либо как `GET` параметр `?api_token=you-api-token`, либо в заголовке `Authorization: Bearer you-api-token`.

####Данные профиля

    [GET] /api/v1/profile
    
Result
   
    {
        profile: {
            id: integer
            email: string
            name: string,
            role: enum,
            status: enum,
        },
        company: Organization,
        permissions: Array of permissions
    }

####Регистрация поставщика

    [POST] /api/v1/register/supplier

| Field                             | Required   |
| --------------------------------- | ---------- |
| `license_agreement`               | yes        |
| `user[email]`                     | yes        |
| `user[password]`                  | yes        |
| `organization[org_type]`          | yes        |
| `organization[first_name]`        | yes        |
| `organization[second_name]`       | yes        |
| `organization[middle_name]`       | yes        |
| `organization[phone]`             | yes        |
| `organization[org_city_id]`       | yes        |
| `organization[org_name]`          | yes        |
| `organization[org_inn]`           | yes        |
| `organization[org_address]`       | yes        |
| `organization[org_address_legal]` | yes        |
| `organization[org_legal_form_id]` | yes        |
| `organization[org_director]`      | yes        |
    
####Регистрация покупателя

    [POST] /api/v1/register/customer
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `license_agreement`               | yes        |
| `user[email]`                     | yes        |
| `user[password]`                  | yes        |
| `organization[org_type]`          | yes        |
| `organization[first_name]`        | yes        |
| `organization[second_name]`       | yes        |
| `organization[middle_name]`       | yes        |
| `organization[phone]`             | yes        |
| `organization[org_city_id]`       | yes        |
| `organization[org_name]`          | yes        |
| `organization[org_inn]`           | yes        |

####КЛАДР

#####Список стран

    [GET] /api/v1/kladr/countries
    
#####Список регионов

    [GET] /api/v1/kladr/regions/:country
    
#####Список городов

    [GET] /api/v1/kladr/cities/:region
    
#####Поиск места

    [GET] /api/v1/register/place?query=place-name
    
Result
       
    {
        cities: [],
        regions: [],
    }
        
#####Тукущее местоположение

    [GET] /api/v1/kladr/position
    
#####Инормация о регионе

    [GET] /api/v1/kladr/region/:region

#####Инормация о стране

    [GET] /api/v1/kladr/country/:country
    
####Новости

#####Новости созданные администраторами

    [GET] /api/v1/news

| Field                             | Required   |
| --------------------------------- | ---------- |
| `category`                        | no         |


#####Получение полной новости

    [GET] /api/v1/news/:news
    
####Древо категорий

Получение древовидного списка категорий

    [GET] /api/v1/category/tree
    
####Фильтр

Фильтры это механизмы поиска новостей, организаций, маркеров и сделок на сайте.

#####Организации

    [GET] /api/v1/filter/organization
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `category`                        | no         |
| `country`                         | no         |
| `region`                          | no         |
| `city`                            | no         |

    [EXAMPLE] /api/v1/filter/organization?category=1,2,3&city=118
    
#####Маркеры организаций

    [GET] /api/v1/filter/markers
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `category`                        | no         |
| `country`                         | no         |
| `region`                          | no         |
| `city`                            | no         |

#####Новости и сделки

    [GET] /api/v1/filter/news
    [GET] /api/v1/filter/stocks
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `category`                        | no         |
| `country`                         | no         |
| `region`                          | no         |
| `city`                            | no         |

#####Сделки

    [GET] /api/v1/filter/deals
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `category`                        | no         |
| `country`                         | no         |
| `region`                          | no         |
| `city`                            | no         |
| `fast_deal`                       | no         |
| `pay_type_cash`                   | no         |
| `pay_type_noncash`                | no         |
| `finish`                          | no         |

####Формы организации

    [GET] /api/v1/legalforms
    
####Организация

#####Информация об организации

    [GET] /api/v1/organization/:id/info
    
#####Новости организации

    [GET] /api/v1/organization/:id/news
    
#####Оценки организации и отзовы

    [GET] /api/v1/organization/:id/rating
    
####Организация - управление

Данные запросы требуют наличия авторизации (см. раздел авторизации).

#####Данные организации

    [Authorized]
    [GET] /api/v1/organization/manage/info
    
#####Редактирование данных организации

    [Authorized]
    [POST] /api/v1/organization/manage/edit
    
В зависимости от типа учетной записи принимаются следующие параметры

| Field                             | Required   |
| --------------------------------- | ---------- |
| `logo`                            | no         |
| `first_name`                      | no         |
| `second_name`                     | no         |
| `middle_name`                     | no         |
| `phone`                           | no         |
| `org_city_id`                     | no         |
| `org_name`                        | no         |
| `org_inn`                         | no         |
| `org_description`                 | no         |

Для пользователя поставщика

| Field                             | Required   |
| --------------------------------- | ---------- |
| `video`                           | no         |
| `image_1`                         | no         |
| `image_2`                         | no         |
| `image_3`                         | no         |
| `org_address`                     | no         |
| `org_address_legal`               | no         |
| `org_legal_form_id`               | no         |
| `org_director`                    | no         |
| `org_site`                        | no         |
| `org_work_time`                   | no         |

#####Обновление списка категорий организации

    [Authorized]
    [POST] /api/v1/organization/manage/categories
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `categories`                      | yes        |

#####Получение списка доступных прав на действия в системе

    [Authorized]
    [GET] /api/v1/organization/manage/permissions
    
#####Получение списка дополнительных аккаунтов

    [Authorized]
    [GET] /api/v1/organization/manage/users
    
#####Создание дополнительного аккаунта

    [Authorized]
    [POST] /api/v1/organization/manage/users/store
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `user[name]`                      | yes        |
| `user[email]`                     | yes        |
| `user[password]`                  | yes        |
| `permissions[]`                   | yes        |

#####Редактирование дополнительного аккаунта

    [Authorized]
    [PATCH] /api/v1/organization/manage/users/:user

| Field                             | Required   |
| --------------------------------- | ---------- |
| `user[name]`                      | yes        |
| `user[email]`                     | yes        |
| `user[password]`                  | yes        |
| `permissions[]`                   | yes        |

#####Удаление дополнительного аккаунта

    [Authorized]
    [DELETE] /api/v1/organization/manage/users/:user
    
#####Список складов

    [Authorized]
    [GET] /api/v1/organization/manage/stores
    
#####Добавление склада

    [Authorized]
    [POST] /api/v1/organization/manage/stores/store
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `address`                         | yes        |
| `geo_lat`                         | yes        |
| `geo_lon`                         | yes        |

#####Удаление склада

    [Authorized]
    [DELETE] /api/v1/organization/manage/stores/delete/:store
    
#####Список офисов

    [Authorized]
    [GET] /api/v1/organization/manage/offices
    
#####Добавление офиса

    [Authorized]
    [POST] /api/v1/organization/manage/offices/store
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `phone`                           | yes        |
| `email`                           | yes        |
| `address`                         | yes        |
| `geo_lat`                         | yes        |
| `geo_lon`                         | yes        |

#####Редактирование офиса

    [Authorized]
    [PATCH] /api/v1/organization/manage/offices/update/:office
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `phone`                           | no         |
| `email`                           | no         |
| `address`                         | yes        |
| `geo_lat`                         | yes        |
| `geo_lon`                         | yes        |

#####Удаление офиса

    [Authorized]
    [DELETE] /api/v1/organization/manage/offices/delete/:office
    
#####Список новостей

    [Authorized]
    [GET] /api/v1/organization/manage/news    
    
#####Список акций

    [Authorized]
    [GET] /api/v1/organization/manage/stocks
    
#####Создание новости

    [Authorized]
    [POST] /api/v1/organization/manage/news/store
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `title`                           | yes        |
| `url`                             | yes        |
| `description`                     | yes        |
| `categories`                      | yes        |
| `image_1`                         | no         |
| `image_2`                         | no         |
| `image_3`                         | no         |
| `stock`                           | no         |

#####Редактирование новости

    [Authorized]
    [PATCH] /api/v1/organization/manage/news/update/:news
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `title`                           | yes        |
| `url`                             | yes        |
| `description`                     | yes        |
| `categories`                      | yes        |
| `image_1`                         | no         |
| `image_2`                         | no         |
| `image_3`                         | no         |
| `stock`                           | no         |

#####Удаление новости

    [Authorized]
    [DELETE] /api/v1/organization/manage/news/delete/:news
    
#####Список уведомлений

    [Authorized]
    [GET] /api/v1/organization/manage/notifications
    
#####Избранное

    [Authorized]
    [GET] /api/v1/organization/favorites
        
#####Избранное - добавление организации

    [Authorized]
    [POST] /api/v1/organization/favorites/add/:organization        
    
#####Избранное - удаление организации

    [Authorized]
    [DELETE] /api/v1/organization/favorites/delete/:organization
    
####Сделки

#####Список шаблонов вопросов

    [GET] /api/v1/deals/questions
    
#####Список моих сделок

Возвращает список созданных сделок или сделок в которых принимается участие

    [Authorized]
    [GET] /api/v1/deals/list
    
#####Информация о сделке

    [GET] /api/v1/deals/:deal
    
#####Создание сделки

    [Authorized]
    [POST] /api/v1/deals/store
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `name`                            | yes        |
| `description`                     | yes        |
| `pay_type_cash`                   | no         |
| `pay_type_noncash`                | no         |
| `budget_from`                     | yes        |
| `budget_to`                       | yes        |
| `fast_deal`                       | no         |
| `favorite_only`                   | no         |
| `deadline_deal`                   | yes        |
| `deadline_service`                | yes        |
| `question`                        | no         |
| `categories`                      | yes        |
| `cities`                          | yes        |
| `questions`                       | no         |

#####Заявка на участие в сделке

    [Authorized]
    [POST] /api/v1/deals/:deal/take

#####Выбор победителя в сделке

    [Authorized]
    [POST] /api/v1/deals/:deal/winner
    
#####Завершение сделки

    [Authorized]
    [POST] /api/v1/deals/:deal/finish
    
####Диалоги

Диалоги частично реализованы на Websocket, и имеют следующие события:
- Глобальная подписка на новые сообщения `dialog.organization.:id`
- Подписка на новые сообщения в рамках диалога `dialog.:id`

#####Список диалогов

    [Authorized]
    [GET] /api/v1/dialogs
    
#####Новый диалог

    [Authorized]
    [POST] /api/v1/dialogs/news

| Field                             | Required   |
| --------------------------------- | ---------- |
| `member_id`                       | yes        |
| `deal_id`                         | yes        |

#####Список сообщений в диалоге

    [Authorized]
    [GET] /api/v1/dialogs/:dialog
    
#####Новое сообщение

    [Authorized]
    [POST] /api/v1/dialogs/:dialog/send
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `message`                         | yes        |
    
####Обратная связь

#####Новое обращение

    [Authorized]
    [POST] /api/v1/feedback/send
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `theme`                           | yes        |
| `description`                     | yes        |

    [POST] /api/v1/feedback/send
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `email`                           | yes        |
| `description`                     | yes        |

#####Новая жалоба

    [Authorized]
    [POST] /api/v1/feedback/report
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `theme`                           | yes        |
| `description`                     | yes        |
| `org_id`                          | no         |
| `news_id`                         | no         |
| `deal_id`                         | no         |
| `message_id`                      | no         |

