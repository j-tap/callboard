<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('user')->group(function () {
    Route::post('login', 'Client\Api\v1\LoginController@login');
    Route::post('callme', 'Client\ClientController@callMe'); // заказ обратного звонка клиентом
    Route::get('profile', 'Client\Api\v1\LoginController@profile')->middleware('auth:api'); // показать профиль юзера
    Route::post('update', 'Client\ClientController@update')->middleware('auth:api'); // обновить профиль юзера
    Route::post('deletephoto', 'Client\ClientController@deletePhoto')->middleware('auth:api'); // удалить фото профиля юзера
    Route::post('password/change', 'Client\Api\v1\LoginController@changePassword')->middleware('auth:api');
    Route::post('/passwordreset', 'Client\ClientController@passwordResetSend')->name('password.reset.send');
 
    Route::get('profile/{id}', 'Client\Api\v1\LoginController@getProfileFromId')->where('id', '[0-9]+'); // показать профиль юзера всем

    Route::prefix('favourites')->middleware('auth:api')->group(function () {
        Route::get('', 'Client\Api\v1\UserSelectedDealsController@favourites'); // вернуть все избранные юзером сделки
        Route::post('/store', 'Client\Api\v1\UserSelectedDealsController@store'); // добавить сделку в избранное 
        Route::post('/delete', 'Client\Api\v1\UserSelectedDealsController@delete'); //удалить сделку из избранного
    });
});

// Registration
Route::prefix('register')->group(function () {
    Route::post('user', 'Client\Api\v1\RegisterController@registerUser');
    Route::post('/repeateregistermail', 'Client\ClientController@repeateRegisterMailSend')->name('repeate.register.send');
    // Route::post('customer', 'Client\Api\v1\RegisterController@registerCustomer'); // todo - убрать после
    // Route::post('supplier', 'Client\Api\v1\RegisterController@registerSupplier'); // todo - убрать после
});

// Kladr
Route::prefix('kladr')->group(function () {

    Route::get('countries', 'Client\Api\v1\KladrController@getCountries');
    Route::get('regions/{country}', 'Client\Api\v1\KladrController@getRegions');
    Route::get('cities/{region}', 'Client\Api\v1\KladrController@getCities');
    Route::get('place', 'Client\Api\v1\KladrController@getPlace'); // поисковая строка, ищет и по региону и по городу и выводит найденое там или там

    Route::get('position', 'Client\Api\v1\KladrController@getPosition');
    Route::get('region/{region}', 'Client\Api\v1\KladrController@getRegion');
    Route::get('country/{country}', 'Client\Api\v1\KladrController@getCountry');
});

// Site news by category
Route::get('news', 'Client\Api\v1\NewsController@news');
Route::get('news/{id}', 'Client\Api\v1\NewsController@newsShow');

// Categories
Route::prefix('category')->group(function () {
    Route::get('tree', 'Client\Api\v1\CategoriesController@categoryTree');
});

// Filter Фильтры
Route::prefix('filter')->group(function () {
    Route::get('organization', 'Client\Api\v1\FilterController@organization'); // получить организации по фильтрам
    Route::get('markers', 'Client\Api\v1\FilterController@markers');
    Route::get('news', 'Client\Api\v1\FilterController@news');
    Route::get('stocks', 'Client\Api\v1\FilterController@stocks');
  //  Route::get('deals', 'Client\Api\v1\FilterController@deals');
    Route::get('deals', 'Client\Api\v1\FilterController@filterDeals'); // получить сделки по фильтрам
});

// Legal Forms
Route::get('legalforms', 'Client\Api\v1\LegalFormsController@getForms');

// Organization Оргвнизации
Route::prefix('organization')->group(function () {
    Route::get('{organization}/info', 'Client\Api\v1\Organization\OrganizationController@info')->where('organization', '[0-9]+'); //информация о организации по ее id, тут и склады и офисы тоже
 //   Route::get('{organization}/news', 'Client\Api\v1\Organization\OrganizationController@news')->where('organization', '[0-9]+'); // TDPD
 //   Route::get('{organization}/ratings', 'Client\Api\v1\Organization\OrganizationController@ratings')->where('organization', '[0-9]+');

    Route::prefix('manage')->middleware('auth:api')->group(function () {
        Route::get('info', 'Client\Api\v1\Organization\OrganizationManageController@organization'); // информация об организации пользователя
        Route::post('store', 'Client\Api\v1\Organization\OrganizationManageController@store'); // создать организацию, тут и склады и офисы тоже
        Route::post('storeimage', 'Client\Api\v1\Organization\OrganizationManageController@storeImage'); // загрузить изображение для организации
        Route::post('deleteimage', 'Client\Api\v1\Organization\OrganizationManageController@deleteImage'); // удалить изображение у организацию
        Route::post('update', 'Client\Api\v1\Organization\OrganizationManageController@update'); //  редактирование организации

      //  Route::post('categories', 'Client\Api\v1\Organization\OrganizationManageController@categoriesEdit'); // прописать категории для организацйии - это теперь в OrganizationManageController@store

        // склады
        Route::get('stores', 'Client\Api\v1\Organization\OrganizationManageController@stores'); // список складов компании
        Route::post('stores/store', 'Client\Api\v1\Organization\OrganizationManageController@storesStore'); // создать склад
        Route::delete('stores/delete/{store}', 'Client\Api\v1\Organization\OrganizationManageController@storesDelete'); // удалить склад

        // офисы
        Route::get('offices', 'Client\Api\v1\Organization\OrganizationManageController@offices'); // список офисов организации
      //  Route::get('offices/{id}', 'Client\Api\v1\Organization\OrganizationManageController@officeView');
        Route::post('offices/store', 'Client\Api\v1\Organization\OrganizationManageController@officesStore'); // создать офис
      //  Route::patch('offices/update/{office}', 'Client\Api\v1\Organization\OrganizationManageController@officesUpdate');
        Route::delete('offices/delete/{office}', 'Client\Api\v1\Organization\OrganizationManageController@officesDelete'); // удалить офис

        Route::get('permissions', 'Client\Api\v1\Organization\OrganizationManageController@permissions');

        Route::get('users', 'Client\Api\v1\Organization\OrganizationManageController@users');
        Route::get('user/{id}', 'Client\Api\v1\Organization\OrganizationManageController@user');
        Route::post('users/store', 'Client\Api\v1\Organization\OrganizationManageController@usersStore');
        Route::patch('users/update/{user}', 'Client\Api\v1\Organization\OrganizationManageController@usersUpdate');
        Route::delete('users/delete/{user}', 'Client\Api\v1\Organization\OrganizationManageController@usersDelete');

      
        Route::get('news', 'Client\Api\v1\Organization\OrganizationNewsController@news');
        Route::post('news/store', 'Client\Api\v1\Organization\OrganizationNewsController@newsStore');
        Route::patch('news/update/{news}', 'Client\Api\v1\Organization\OrganizationNewsController@newsUpdate');
        Route::delete('news/delete/{news}', 'Client\Api\v1\Organization\OrganizationNewsController@newsDelete');

        Route::get('stocks', 'Client\Api\v1\Organization\OrganizationNewsController@stocks');
    });

    Route::middleware('auth:api')->group(function () {
        Route::get('notifications', 'Client\Api\v1\Organization\NotificationsController@notifications');
    });

    Route::prefix('favorites')->middleware('auth:api')->group(function () {
        Route::get('', 'Client\Api\v1\Organization\FavoritesController@favorites');
        Route::post('/add/{organization}', 'Client\Api\v1\Organization\FavoritesController@add');
        Route::delete('/delete/{organization}', 'Client\Api\v1\Organization\FavoritesController@delete');
    });
});

// Deals Заявки Сделки
Route::prefix('deals')->group(function () {
    Route::get('questions', 'Client\Api\v1\DealController@dealsQuestions');
   // Route::get('dealsBeforeTo', 'Client\Api\v1\DealController@runDeleteDealsBeforeToDateWorker');
	Route::get('list', 'Client\Api\v1\DealController@dealsList'); // список всех заявок
	Route::get('user/list', 'Client\Api\v1\DealController@dealsListCurrentUser')->middleware('auth:api'); // список всех заявок залогиненого юзера

    Route::middleware('auth:api')->group(function () {
        Route::post('store', 'Client\Api\v1\DealController@dealsStore');  // создать заявку
        Route::post('update/{id}', 'Client\Api\v1\DealController@dealsUpdate');  // обновить заявку
        Route::post('{id}/take', 'Client\Api\v1\DealController@dealsTake');
        Route::post('{id}/winner', 'Client\Api\v1\DealController@dealsSetWinner');
        Route::post('{id}/finish', 'Client\Api\v1\DealController@dealsFinish'); // завершить заявку
        Route::post('deleteimage', 'Client\Api\v1\DealController@dealsImageDelete'); // удалить картинку по ее id

        // архив сделок
        Route::get('deleteddealslist', 'Client\Api\v1\DealController@deletedDealsList'); // вернуть удаленные заявки пользователя
        Route::post('restoredeal/{id}', 'Client\Api\v1\DealController@restoreDeal'); // вернуть удаленные заявки пользователя

        
    });

    Route::get('{id}', 'Client\Api\v1\DealController@dealsShow'); // показать заявку по ее id
});

// Dialogs Диалоги
Route::prefix('dialogs')->middleware('auth:api')->group(function () {
    Route::post('new', 'Client\Api\v1\DialogsController@newDialog'); // создать новое сообщение, кнокпа НАПИСАТЬ
    Route::get('', 'Client\Api\v1\DialogsController@dialogs'); // вернуть список диалогов с другими компаниями
    Route::get('{id}', 'Client\Api\v1\DialogsController@dialog'); // получить сообщения по конкретному диалогу
    Route::delete('{id}', 'Client\Api\v1\DialogsController@delete');  // удалить диалог
    Route::post('{id}/send', 'Client\Api\v1\DialogsController@send'); // отправить сообщение в диалог

    Route::get('messages/countunreaded', 'Client\Api\v1\DialogsController@countUnreaded'); // не прочитанные сообщения
    Route::post('messages/markreaded', 'Client\Api\v1\DialogsController@markReaded'); // сделать сообщение прочитанным
});

// Feedback
Route::post('feedback/send', 'Client\Api\v1\FeedbackController@send');
Route::middleware('auth:api')->group(function () {
    Route::post('feedback/report', 'Client\Api\v1\FeedbackController@report');
});


// Payment Services ========================

// тарифы и сервисы для не авторизованных
Route::prefix('paymentservice')->group(function () {
    Route::get('/tariffsavailableforall', 'Client\Api\v1\PaymentServicesController@getTariffAvailableForAll')->name('paymentservice.gettariffavailableforall.get');
    Route::get('/servicesavailableforall', 'Client\Api\v1\PaymentServicesController@getServiceAvailableForAll')->name('paymentservice.getserviceavailableforall.get');
});

Route::prefix('paymentservice')->middleware('auth:api')->group(function () {

    Route::post('/get/score', 'Client\Api\v1\ScoreClientController@generateScoreClient')->name('paymentservice.get.score');

    // виды подписок и работа с нимим
    Route::get('/tariffsavailableforuser', 'Client\Api\v1\PaymentServicesController@getTariffAvailableForUser')->name('paymentservice.gettariffavailableforuser.get');
    Route::get('/servicesavailableforuser', 'Client\Api\v1\PaymentServicesController@getServiceAvailableForUser')->name('paymentservice.getserviceavailableforuser.get');

    // админка
    Route::get('/subscriptions', 'Client\Api\v1\PaymentServicesController@getSubscription')->name('paymentservice.subscription.get');
    Route::get('/subscriptions/{id}', 'Client\Api\v1\PaymentServicesController@getSubscriptionFromId')->name('paymentservice.subscription.getfromid');
    Route::get('/subscriptions/filter/filters', 'Client\Api\v1\PaymentServicesController@getSubscriptionFromFilter')->name('paymentservice.subscription.getfromfilter');
    Route::post('/subscriptions', 'Client\Api\v1\PaymentServicesController@storeSubscription')->name('paymentservice.subscription.store');
    Route::post('/subscriptions/{id}', 'Client\Api\v1\PaymentServicesController@updateSubscription')->name('paymentservice.subscription.update');
    Route::delete('/subscriptions/{id}', 'Client\Api\v1\PaymentServicesController@deleteSubscription')->name('paymentservice.subscription.delete');
    // активация платной подписки
    Route::post('/subscriptions/{typeService}/activate', 'Client\Api\v1\PaymentServicesController@activateSubscription')->name('paymentservice.subscription.activate');
    // покупка платной подписки
    Route::post('/subscriptions/{typeService}/payment', 'Client\Api\v1\PaymentServicesController@paymentSubscription')->name('paymentservice.subscription.payment');
    // возможность покупки услуги
    Route::get('/{typeService}', 'Client\Api\v1\PaymentServicesController@paymentServiceIsPossible');
    
});

// Javascript log
Route::post('log/js', 'Client\Api\v1\LogController@write');


//create buy deal landing
Route::post('landingorder', 'Client\Api\v1\AutomaticApplication@index');

//send email support (mantis)
Route::post('/send/support', 'Client\Api\v1\SupportController@index');



// Api 404
Route::any('/{any?}', function() {
    throw new \App\Exceptions\NotFoundException();
})->where('any', '.*')->name('api.v1.notfound');