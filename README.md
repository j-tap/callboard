# mvp-tamtem система

Система создания и заключения заявок между поставщиками и покупателями. 

**В текущей версии реализовано:**
- Регистрация участников системы
- Отправка email и уведомлений
- Определение местоположения
- Создание заявок
- Участие в Заявках
- Редактирование профиля
- Создание новостей
- Загрузка изображений
- Диалоги на Laravel-Echo-Server
- Жалобы
- Обратная связь
- Доп. аккаунты пользователей с настройкой пра доступа
- Фильтры
    - Организаций
    - Новостей
    - заявок
    - Маркеров на карту
- Панель администратора

Документацмя по метадам API находится в `/docs/api.md`

Используемые технологии:
- Laravel 5.x
- Redis
- MySQL
- Laravel Echo Server
- VueJS
- php 7.x

##Установка

git clone http://gitlab.tecman.ru/roman/b2b
cd b2b
mcedit .env #Check options for Database, Redis, EMAIL, Queue druver, set Broadcast drive as Redis
mcedit laravel-echo-server.json # Set you server addr for auth host
composer update
php artisan migrate
php artisan db:seed
php artisan key:generate
npm install
npm run dev # or prod
# Start as service
# Start redis-server
!!!!  при релизе нового кода нужно перезагрузать echo-server  и  воркеры очереди  !!!!
laravel-echo-server start
php artisan queue:work --queue=geo,default --tries=3  (https://www.youtube.com/watch?v=eqKEbJzkpGc&t=3s  - автоперезапуск очереди - для админа)

Запускаем крон для периодических заданий, каждый час будут запускаться
 crontab -e
 @hourly php /... path_to_the_artisan ... /artisan schedule:run >> /dev/null 2>&1


Убедитесь в правильности установки и в том что верно настроили среду для проекта.

Панель администратора доступна по адресу http://localhost/admin, `l: admin@admin.com, p: admin`

**Релиз нового кода:**
- остановить echo-server  и  воркеры очереди  
- php artisan down
- Забрать код из гита
- composer install
- composer dump-autoload
- php artisan migrate
- php artisan cache:clear
- php artisan config:cache
- php artisan up
- запустить echo-server  и  воркеры очереди 

# API mvp-tamtem

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

#### Составные сущности

##### Организация

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
    
#####Заявка

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
        finished_at: Date,
        winner: Organization,
        winner_id: Integer,
        organization: {
            id: Integer,
            name: String,
        },
        owner: {
            id: Integer,
            name: String,
            phone: String,
            photo: url,
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
        },
        status: String,
        favourited: Boolean,
        subtype_deal: String
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

####Авторизация - new ----------------------------------------------------------------------------------------------------

    [POST] /api/v1/user/login

| Field      | Required   |
| ---------- | ---------- |
| `password` | yes |
| `email`    | yes |
    
Возвращает `api_token`, который используется для запросов требующих авторизацию. 
Указывается либо как `GET` параметр `?api_token=you-api-token`, либо в заголовке `Authorization: Bearer you-api-token`.


####Регистрация пользователя - new -------------------------------------------------------------------------------------------------------------

    [POST] /api/v1/register/user

| Field                             | Required   |
| --------------------------------- | ---------- |
| `name`                            | yes        |
| `user[email]`                     | yes        |
| `user[password]`                  | yes        |

####Послать повторно письмо с подтверждением почты - new -----------------------------------------------------------------------

    [POST] /api/v1/register/repeateregistermail

| Field                             | Required   |
| --------------------------------- | ---------- |
| `email`                           | yes        |


####Данные профиля ЛК- new --------------------------------------------------------------------------------------------------------------------

    [GET] /api/v1/user/profile
    
Result
   
    {
        profile: {
            id: integer
            email: string
            name: string,
            role: enum,
            status: enum,
            unique_id: integer,
            is_org_created: 1|0
            phone: string ,
            photo: string, -url  to photo
        },
        permissions: Array of permissions,
        company: Organization,      -  если создана организация юзером
    }

####Данные профиля ЛК публичные (для всех), по id юзера - new ----------------------------------------------------------------------------------------------

    [GET] /api/v1/user/profile/:id
    
Result
   
    {
        profile: {
            id: integer
            email: string
            name: string,
            phone: string ,
            photo: string, -url  to photo
        },
        company: Organization,      -  если создана организация юзером
        city: {
            id: integer
            name: string
        }, 
        region: {
            id: integer
            name: string
        }, 
        country: {
            id: integer
            name: string
        }, 
        categories: [ 
            {
                id: integer
                name: string
            }
        ], 
        stores: [ 
            {
                id: integer
                address: string
                location: {
                        lat: 
                        lon: 
                    }
            }
        ], 
        offices: [ 
            {
                id: integer
                address: string
                phone: string
                email: string
                location: {
                        lat: 
                        lon: 
                    }
            }
        ], 
    }


####Редактировать данные профиля ЛК- new -------------------------------------------------------------------------------------------------------------------

    [Authorized]
    [POST] /api/v1/user/update
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `name`                            | no         |
| `phone`                           | no         |
| `photo`                           | no         |

Result
   
    {
        result: true,
        data: {
            id: integer,
            name: string,
            email: string,
            unique_id: integer,
            phone: string,
            photo: string,
            organization_id: integer,
            role: string,
            status: string,
            is_org_created: 1|0,
        }
    }


####Удалить фото профиля ЛК- new -------------------------------------------------------------------------------------------------------------------
   
    [Authorized]
    [POST] /api/v1/user/deletephoto
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `path`                            | yes        |


Result
   
    {
        result: true|false,
    }

####Заказ клиентом звонка в службу поддержки- new -------------------------------------------------------------------------------------------------------------------
   
    [POST] /api/v1/user/callme
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `phone`                           | yes        |


Result
   
    {
        result: true,
        data : "Письмо в службу поддержки успешно отправлено, ожидайте звонок в ближайшее время"
    }

####КЛАДР

#####Список стран

    [GET] /api/v1/kladr/countries
    
#####Список регионов

    [GET] /api/v1/kladr/regions/:country
    
#####Список городов

    [GET] /api/v1/kladr/cities/:region
    
#####Поиск места - new -------------------------------------------------------------------------------------------------------------

    [GET] /api/v1/register/place?query=place-name
    
Result
       
    {
        cities: [],
            id: integer,
            name: string,
            geo_lat: double,
            geo_lon: double,
            region_id: integer,
            region_name: string
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
    
####Фильтр  - new -------------------------------------------------------------------------------------------------------------

Фильтры это механизмы поиска новостей, организаций, маркеров и заявок на сайте.

#####Организации по фильтрам - new -------------------------------------------------------------------------------------------------------------

    [GET] /api/v1/filter/organization
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `categories[]`                    | no         | id категории (передается массив)
| `cities[]`                        | no         | id города (передается массив)
| `search`                          | no         | строка поиска по названию компании, или ее описанию

    
#####Маркеры организаций

    [GET] /api/v1/filter/markers
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `category`                        | no         |
| `country`                         | no         |
| `region`                          | no         |
| `city`                            | no         |

#####Новости и Заявки

    [GET] /api/v1/filter/news
    [GET] /api/v1/filter/stocks
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `category`                        | no         |
| `country`                         | no         |
| `region`                          | no         |
| `city`                            | no         |

#####Получить Объявления по фильтрам - new -------------------------------------------------------------------------------------------------------------

    [GET] /api/v1/filter/deals
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `type_deal`                       | no         | 'sell'|'buy'
| `subtype_deal`                    | no         | 'new'|'used'|'na' 
| `categories[]`                    | no         | id категории (передается массив)
| `cities[]`                        | no         | id города (передается массив)
| `date_created`                    | no         | 'ASC', 'DESC'   - сортировка по возрастанию даты создания объявления, и по убыванию
| `date_deadline`                   | no         | 'ASC', 'DESC'   - сортировка по возрастанию даты истечения объявления, и по убыванию
| `with_photo`                      | no         |  0|1 -     1 - показывать с фото
| `deal_name`                       | no         |  string -     ищет строку в заголовке объявления
| `budget_from`                     | no         |  минимальная цена в объявлении
| `budget_to`                       | no         |  максимальная цена в объявлении
| `city`                            | no         |  id города -  для упрощенного поиска по объявлению
| `finish`                          | no         |  0|1  -    1- показывать завершщенные сделки
| `user_id`                         | no         |  сделки пользователя с соотв. id


####Формы организации

    [GET] /api/v1/legalforms
    
####Организация

#####Информация об организации по ее ID - new --------------------------------------------------------------------

    [GET] /api/v1/organization/:id/info
    
#####Новости организации

    [GET] /api/v1/organization/:id/news
    
#####Оценки организации и отзывы

    [GET] /api/v1/organization/:id/rating
    
####Организация - управление

Данные запросы требуют наличия авторизации (см. раздел авторизации).

#####Удалить изображение из организации по его пути - new -------------------------------------------------

Удалить изображение  его пути path.  Проверяется, если это изображение не этот юзер размещал, то не удаляем

    [Authorized]
    [POST] /api/v1/organization/manage/deleteimage

    | Field                             | Required   |
    | --------------------------------- | ---------- |
    | `path`                            | yes        |

#####Загрузить изображение для организации  - new -------------------------------------------------

    [Authorized]
    [POST] /api/v1/organization/manage/storeimage

    | Field                             | Required   |
    | --------------------------------- | ---------- |
    | `logo`                            | no         |
    | `image_1`                         | no         |
    | `image_2`                         | no         |
    | `image_3`                         | no         |

    Одно из полей должно быть в запросе обязательно, оно же и единственное

#####Данные организации  - new --------------------------------------------------------------------

    [Authorized]
    [GET] /api/v1/organization/manage/info


#####Создание организации  - new -------------------------------------------------------------------- 

    [Authorized]
    [POST] /api/v1/organization/manage/store

    | Field                             | Required   |
    | --------------------------------- | ---------- |
    | `first_name`                      | no         |
    | `second_name`                     | no         |
    | `middle_name`                     | no         |
    | `phone`                           | no         |
    | `org_city_id`                     | yes        |
    | `org_name`                        | no         |
    | `org_inn`                         | yes        |
    | `org_kpp`                         | yes        | 
    | `org_description`                 | no         |
    | `org_products`                    | no         |  краткое описание ,чем занимается компания 280 симв
    | `video`                           | no         |
    | `logo`                            | no         |
    | `image_1`                         | no         |
    | `image_2`                         | no         |
    | `image_3`                         | no         |
    | `org_address`                     | no         |
    | `org_address_legal`               | no         |
    | `org_legal_form_id`               | yes        |
    | `org_director`                    | no         |
    | `org_site`                        | no         |
    | `org_work_time`                   | no         |
    | `categories`[]                    | YES        | arrary [category_ids]
    | `offices`[]                       | YES        | arrary [JSON]
    | `stores`[]                        | YES        | arrary [JSON]

`categories`[] = [1,45,67]
`offices`[] = {"address" : "Брянск, Орловская 11", "phone": "5639429", "geo_lat" : null ,  "geo_lon" : null}
`stores` [] = {"address" : "Брянск, Орловская 10", "geo_lat" : null ,  "geo_lon" : null}


#####Редактирование данных организации  - new -------------------------------------------------------------------- 

    [Authorized]
    [POST] /api/v1/organization/manage/update

    | Field                             | Required   |
    | --------------------------------- | ---------- |
    | `first_name`                      | yes        |
    | `second_name`                     | yes        |
    | `middle_name`                     | yes        |
    | `phone`                           | no         |
    | `org_city_id`                     | yes        |
    | `org_name`                        | no         |
    | `org_inn`                         | no         |
    | `org_kpp`                         | yes        | 
    | `org_description`                 | no         |
    | `org_products`                    | no         |  краткое описание ,чем занимается компания 280 симв
    | `video`                           | no         |
    | `logo`                            | no         |
    | `image_1`                         | no         |
    | `image_2`                         | no         |
    | `image_3`                         | no         |
    | `org_address`                     | yes        |
    | `org_address_legal`               | yes        |
    | `org_legal_form_id`               | yes        |
    | `org_director`                    | no         |
    | `org_site`                        | no         |
    | `org_work_time`                   | no         |
    | `categories`[]                    | YES        | arrary [category_ids]

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
    
#####Список складов  - new -------------------------------------------------------

    [Authorized]
    [GET] /api/v1/organization/manage/stores
    
#####Добавление склада   - new -------------------------------------------------------

    [Authorized]
    [POST] /api/v1/organization/manage/stores/store
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `address`                         | yes        |
| `geo_lat`                         | no         |
| `geo_lon`                         | no         |

#####Удаление склада по его id  - new -------------------------------------------------------

    [Authorized]
    [DELETE] /api/v1/organization/manage/stores/delete/:store
    
#####Список офисов - new -------------------------------------------------------

    [Authorized]
    [GET] /api/v1/organization/manage/offices
    
#####Добавление офиса  - new -------------------------------------------------------

    [Authorized]
    [POST] /api/v1/organization/manage/offices/store
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `address`                         | yes        |
| `phone`                           | no         |
| `email`                           | no         |
| `geo_lat`                         | no         |
| `geo_lon`                         | no         |

#####Редактирование офиса  - new -------------------------------------------------------

    [Authorized]
    [PATCH] /api/v1/organization/manage/offices/update/:office
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `phone`                           | no         |
| `email`                           | no         |
| `address`                         | yes        |
| `geo_lat`                         | yes        |
| `geo_lon`                         | yes        |

#####Удаление офиса   - new -------------------------------------------------------

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
    
##### Список уведомлений

    [Authorized]
    [GET] /api/v1/organization/manage/notifications
    
##### Избранное - организации

    [Authorized]
    [GET] /api/v1/organization/favorites
        
##### Избранное - добавление организации

    [Authorized]
    [POST] /api/v1/organization/favorites/add/:organization        
    
##### Избранное - удаление организации

    [Authorized]
    [DELETE] /api/v1/organization/favorites/delete/:organization
    
##### Избранное - выдать избранные пользователем сделки из его избранного- new -------------------------------------------------------

    [Authorized]
    [GET] /api/v1/user/favourites
        
##### Избранное - добавление сделки в избранное пользователя- new --------------------------------------------

    [Authorized]
    [POST] /api/v1/user/favourites/store        

    | Field                             | Required   |
    | --------------------------------- | ---------- |
    | `deal_id`                         | yes        |
    
##### Избранное - удаление сделки из избранного - new -------------------------------------------------------

    [Authorized]
    [POST] /api/v1/user/favourites/delete

    | Field                             | Required   |
    | --------------------------------- | ---------- |
    | `deal_id`                         | yes        |
    
#### Заявки

##### Список шаблонов вопросов

    [GET] /api/v1/deals/questions
    
##### Список заявок - new -------------------------------------------------------


    [Authorized]
    [GET] /api/v1/deals/list

    | Field                             | Required   |
    | --------------------------------- | ---------- |
    | `categories`                      | no         |
    | `countries`                       | no         |
    | `regions`                         | no         |
    | `cities`                          | no         |
    | `finish`                          | no         |
    | `type_deal`                       | no         | 'sell'|'buy'
    | `subtype_deal`                    | no         | 'new'|'used'|'na'
    | `user_id`                         | no         | получить заявки юзера по его Id

    если finish = 1  - то показ только продаж удаленных, иначе только не удаленных
    
##### Список заявок текущего пользователя - new -------------------------------------------------------

    [Authorized]
    [GET] /api/v1/deals/user/list

    | Field                             | Required   |
    | --------------------------------- | ---------- |
    | `categories`                      | no         |
    | `countries`                       | no         |
    | `regions`                         | no         |
    | `cities`                          | no         |
    | `finish`                          | no         |
    | `type_deal`                       | no         | 'sell'|'buy'
    | `subtype_deal`                    | no         | 'new'|'used'|'na'
    | `status`                          | no         | 'moderation'|'approve'|,'archive'|'banned'
    | `user_id`                         | no         | 

###### Список архивных заявок текущего пользователя - new --------------------------------------

    [Authorized]
    [GET] /api/v1/deals/user/list?status=archive&finish=1

###### Список заявок на модерации текущего пользователя - new ---------------------------------

    [Authorized]
    [GET] /api/v1/deals/user/list?status=moderation

###### Список заявок не прошедших модерацию для текущего пользователя - new -------------------

    [Authorized]
    [GET] /api/v1/deals/user/list?status=banned&finish=1

##### Удалить изображение из Заявки - new -------------------------------------------------

Удалить изображение из обюъявления пор его id.  Проверяется, если это изображение не этот юзер размещал, то не удаляем

    [Authorized]
    [POST] /api/v1/deals/deleteimage

    | Field                             | Required   |
    | --------------------------------- | ---------- |
    | `id`                              | yes        |

    
##### Информация о Заявке  - new -------------------------------------------------------

    [GET] /api/v1/deals/:deal
    
##### Создание Заявки - new --------------------------------------------------------------

    [Authorized]
    [POST] /api/v1/deals/store
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `type_deal`                       | yes        | 'sell'|'buy'
| `subtype_deal`                    | yes        | 'new'|'used'|'na'
| `name`                            | yes        |
| `description`                     | no         |
| `budget_to`                       | yes        | if type_deal = 'sell'
| `is_need_kp`                      | no         | if type_deal = 'sell'
| `deadline_deal`                   | no         |
| `categories` []                   | yes        |
| `cities`  []                      | yes        |
| `images`  []                      | no         |

##### Редактирование Заявки - new --------------------------------------------------------------

    [Authorized]
    [POST] /api/v1/deals/update/:id
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `type_deal`                       | yes        | 'sell'|'buy'
| `subtype_deal`                    | yes        | 'new'|'used'|'na'
| `name`                            | yes        |
| `description`                     | no         |
| `budget_to`                       | yes        | if type_deal = 'sell'
| `is_need_kp`                      | no         | if type_deal = 'sell'
| `deadline_deal`                   | no         |
| `categories` []                   | yes        |
| `cities`  []                      | yes        |
| `images`  []                      | no         |

##### Удаление (Завершение) Заявки (отметить, как удаленную) - new --------------------------------------

    [Authorized]
    [POST] /api/v1/deals/:deal/finish

    по сути, проставляет:
         organizations_deals.finish = 1 
         organizations_deals.status = 'archive'
         organizations_deals.finished_at = now()

##### Архив заявок. Список заявок залогиненного пользователя из архива - new ----------------------------

    [Authorized]
    [GET] /api/v1/deals/deleteddealslist

    ! Если пользователь - администратор, то выдает список всех архивных заявок, иначе, только своих.


##### Архив заявок. Вернуть заявку из архива в строй по ее id (она уходит опять на модерацию) - new ------

    [Authorized]
    [GET] /api/v1/deals/restoredeal/:id

     ! Если пользователь - администратор, то дает вернуть любую заявку, иначе - только свою

     по сути, проставляет:
         organizations_deals.finish = 0 
         organizations_deals.status = 'moderation'
         organizations_deals.finished_at = null

##### Заявка на участие в Заявке

    [Authorized]
    [POST] /api/v1/deals/:deal/take

##### Выбор победителя в Заявке

    [Authorized]
    [POST] /api/v1/deals/:deal/winner
    
    
#### Диалоги

Диалоги частично реализованы на Websocket, и имеют следующие события:
# - Глобальная подписка на новые сообщения `dialog.organization.:id`
- Подписка на новые сообщения в рамках диалога `dialog.:id`

##### Список всех диалогов текущего юзера - new ----------------------------------------

    [Authorized]
    [GET] /api/v1/dialogs
    
##### Новый диалог по заявке с id  =  deal_id - new -------------------------------------

    [Authorized]
    [POST] /api/v1/dialogs/new

| Field                             | Required   |
| --------------------------------- | ---------- |
| `deal_id`                         | yes        |

##### Список сообщений в диалоге - new ----------------------------------------------------

    [Authorized]
    [GET] /api/v1/dialogs/:dialogId
    
##### Новое сообщение в диалог - new -----------------------------------------------------

    [Authorized]
    [POST] /api/v1/dialogs/:dialog/send
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `message`                         | yes        |
    
##### Удалить диалог - new --------------------------------------------------------------

    [Authorized]
    [DELETE] /api/v1/dialogs/:dialogId

##### Количество непрочитанных сообщений во всех диалогах юзера - new -------------------

    [Authorized]
    [GET] /api/v1/dialogs/messages/countunreaded  

##### Пометить сообщение прочитанным, по его id - new -----------------------------------

    [Authorized]
    [POST] /api/v1/dialogs/messages/markreaded
    
| Field                             | Required   |
| --------------------------------- | ---------- |
| `id`                              | yes        |

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


#### Платные услеги и сервисы  - new --------------------------------------------------------------


##### Получить список всех имеющихся платных услуг (для администратора)- new ---------------------------------

    [Authorized]
    [GET] /api/v1/paymentservice/subscriptions

##### Получить список всех доступных услуг (для пользователя)- new -----------------------------------------

    [Authorized]
    [GET] /api/v1/paymentservice/servicesavailableforuser

##### Получить список всех доступных  услуг (для не авторизованного пользователя)- new ----------------------

    [GET] /api/v1/paymentservice/servicesavailableforall

##### Получить список всех доступных тарифов (для пользователя)- new ----------------------------------------

    [Authorized]
    [GET] /api/v1/paymentservice/tariffsavailableforuser

##### Получить список всех доступных тарифов (для  не авторизованного пользователя)- new --------------------

    [GET] /api/v1/paymentservice/tariffsavailableforall

##### Получить описание платной услуги по ее ID - new -----------------------------------------

    [Authorized]
    [GET] /api/v1/paymentservice/subscriptions/:id

##### Создать новую платную услугу - new ------------------------------------------------------

    [Authorized]
    [POST] /api/v1/paymentservice/subscriptions 

| Field                             | Required   |
| --------------------------------- | ---------- |
| `name`                            | yes        | название услуги
| `slug`                            | yes        | краткое имя услуги (уникальный ЧП идентификатор), напр. "payment_all_in_3_days"
| `description`                     | no         | более полное описание услуги
| `started_at`                      | no         | дата старта услуги 
| `duration_days`                   | no         | продолжительность действия услуги, в днях, по умолчанию : 0 - бессрочно
| `status`                          | no         | статус ('pause', 'finished', 'active'), по умолчанию : 'pause'
| `cost`                            | no         | стоимость услуги, по умолчанию : 0 - акция или подарок
| `type`                            | no         | тип (это тариф или сервис)
| `parent_id`                       | no         | id родительской услуги : null.   Чтобы сделать пакет или сделать отношения. например есть проаккаунт, и сделать про аккаунт , но на 3 дня

##### Редактировать платную услугу по ее id - new ------------------------------------------------------

    [Authorized]
    [POST] /api/v1/paymentservice/subscriptions/:id

| Field                             | Required   |
| --------------------------------- | ---------- |
| `name`                            | no         | название услуги
| `slug`                            | no         | краткое имя услуги (уникальный ЧП идентификатор), напр. "payment_all_in_3_days"
| `description`                     | no         | более полное описание услуги
| `started_at`                      | no         | дата старта услуги 
| `duration_days`                   | no         | продолжительность действия услуги, в днях, по умолчанию : 0 - бессрочно
| `status`                          | no         | статус ('pause', 'finished', 'active'), по умолчанию : 'pause'
| `cost`                            | no         | стоимость услуги, по умолчанию : 0 - акция или подарок
| `type`                            | no         | тип (это тариф или сервис)
| `parent_id`                       | no         | id родительской услуги : null.   Чтобы сделать пакет или сделать отношения. например есть проаккаунт, и сделать про аккаунт , но на 3 дня

##### Удалить платную услугу по ее id - new ------------------------------------------------------

    [Authorized]
    [DELETE] /api/v1/paymentservice/subscriptions/:id

##### Активировать платную услугу по ее slug (typeservice) - new ------------------------------------------------------

    [Authorized]
    [POST] /api/v1/paymentservice/subscriptions/:typeservice/activate

typeservice - имя-слаг услуги из БД

##### Купить тариф по его slug (typeservice) - new ------------------------------------------------------

    [Authorized]
    [POST] /api/v1/paymentservice/subscriptions/:typeservice/payment

typeservice - имя-слаг тарифа из БД

| Field                             | Required   |
| --------------------------------- | ---------- |
| `deal_id`                         | no         | id объявления о куплю - если покупаем услугу на просмотр контактов по объявлению

##### Получить описание возожности получения платной услуги по ее slug (typeservice) - new -----------------------------------------

Данный запрос выполняется с фронта перед посылкой на покупку или подписку на сервис, как проверка возможности подписки вообще и предупреждение о платности и стоимости

    [Authorized]
    [GET] /api/v1/paymentservice/:typeservice

  typeservice - имя-слаг услуги из БД  

  Например: /api/v1/paymentservice/payment_all_in_3_days   , вернет

    "result": true,
    "data": {
        "is_pro_account": true,
        "ballance": 370,
        "is_possible": true,
        "message": "Для вас возможно все! У вас подписка на сервис: Pro аккаунт в подарок на 3 дня",
        "cost_of_service": 0,
        "started_at": "2019-05-31 10:45:14"
    }

    is_pro_account - если действует Pro аккаунт, т.е. юзеру доступны все возможности сайта
    ballance - кол-во денег на счету пользователя
    is_possible - есть ли в принципе возможность у юзера получить данный сервис (если false, то либо не хватает денег. либо какая-то другая причина)
    message - сообщение для пользователя
    cost_of_service - стоимость сервиса для покупки (если 0 , то бесплатно или у юзера Pro аккаунт)
    started_at - дата активации сервиса у юзера

##### Получить описание платных услуг по фильтрам - new ------------------------------------------------------

    [Authorized]
    [GET] /api/v1/paymentservice/subscriptions/filter/filters

| Field                             | Required   |
| --------------------------------- | ---------- |
| `name`                            | no         | название услуги
| `slug`                            | no         | краткое имя услуги (уникальный ЧП идентификатор), напр. "payment_all_in_3_days"
| `started_at`                      | no         | дата старта услуги 
| `duration_days`                   | no         | продолжительность действия услуги, в днях
| `status`                          | no         | статус ('pause', 'finished', 'active')
| `cost`                            | no         | стоимость услуги
| `parent_id`                       | no         | id родительской услуги