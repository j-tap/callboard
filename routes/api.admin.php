<?php

// ToDo - fixmi add routes group
// ToDo - Please REFACTOR controllers and add API Trait =)

Route::middleware(['auth'])->group(function () {
    Route::get('profile', 'Admin\ProfileController@profile')->name('profile');
    Route::get('sysinfo', 'Admin\AdminController@systemInfo')->name('sys.info');
    Route::get('statistic', 'Admin\AdminController@statistic')->name('statistic');
    Route::get('permissions', 'Admin\PermissionsController@permissions')->name('permissions.list');
    Route::get('permissions/site', 'Admin\PermissionsController@permissionsSite')->name('permissions.site');

    Route::prefix('kladr')->group(function() {
        Route::get('countries', 'Admin\KladrController@getCountries')->name('kladr.countries');
        Route::get('regions/{country}', 'Admin\KladrController@getRegions')->name('kladr.regions');
        Route::get('cities/{region}', 'Admin\KladrController@getCities')->name('kladr.cities');
        // Kladr CRUD
        Route::prefix('city')->group(function() {
            Route::post('store', 'Admin\KladrController@cityStore')->name('kladr.cities.store')->middleware('permission:kladr.create');
            Route::get('{id}', 'Admin\KladrController@cityShow')->name('kladr.cities.show');
            Route::patch('{id}', 'Admin\KladrController@cityUpdate')->name('kladr.cities.update')->middleware('permission:kladr.edit');
            Route::delete('{id}', 'Admin\KladrController@cityDelete')->name('kladr.cities.delete')->middleware('permission:kladr.delete');
        });

        Route::prefix('region')->group(function() {
            Route::post('store', 'Admin\KladrController@regionStore')->name('kladr.regions.store')->middleware('permission:kladr.create');
            Route::get('{id}', 'Admin\KladrController@regionShow')->name('kladr.regions.show');
            Route::patch('{id}', 'Admin\KladrController@regionUpdate')->name('kladr.regions.update')->middleware('permission:kladr.edit');
            Route::delete('{id}', 'Admin\KladrController@regionDelete')->name('kladr.regions.delete')->middleware('permission:kladr.delete');
        });

        Route::prefix('country')->group(function() {
            Route::post('store', 'Admin\KladrController@countryStore')->name('kladr.countries.store')->middleware('permission:kladr.create');
            Route::get('{id}', 'Admin\KladrController@countryShow')->name('kladr.countries.show');
            Route::patch('{id}', 'Admin\KladrController@countryUpdate')->name('kladr.countries.update')->middleware('permission:kladr.edit');
            Route::delete('{id}', 'Admin\KladrController@countryDelete')->name('kladr.countries.delete')->middleware('permission:kladr.delete');
        });
    });
    //

    Route::prefix('deals/questions')->group(function() {
        Route::get('', 'Admin\DealsQuestionsController@index')->name('deals.questions.index')->middleware('permission:dealquestion.show');
        Route::post('store', 'Admin\DealsQuestionsController@store')->name('deals.questions.store')->middleware('permission:dealquestion.create');
        Route::get('{id}', 'Admin\DealsQuestionsController@show')->name('deals.questions.show')->middleware('permission:dealquestion.show');
        Route::patch('{id}', 'Admin\DealsQuestionsController@update')->name('deals.questions.update')->middleware('permission:dealquestion.edit');
        Route::delete('{id}', 'Admin\DealsQuestionsController@delete')->name('deals.questions.delete')->middleware('permission:dealquestion.delete');
    });

    Route::prefix('orgs/legalforms')->group(function() {
        Route::get('', 'Admin\LegalFormsController@index')->name('legalforms.index');
        Route::post('store', 'Admin\LegalFormsController@store')->name('legalforms.store')->middleware('permission:legalforms.create');
        Route::get('{id}', 'Admin\LegalFormsController@show')->name('legalforms.show')->middleware('permission:legalforms.show');
        Route::patch('{id}', 'Admin\LegalFormsController@update')->name('legalforms.update')->middleware('permission:legalforms.edit');
        Route::delete('{id}', 'Admin\LegalFormsController@delete')->name('legalforms.delete')->middleware('permission:legalforms.delete');
    });

    Route::prefix('categories')->group(function() {
        Route::get('', 'Admin\CategoryController@index')->name('category.index');
        Route::post('store', 'Admin\CategoryController@store')->name('category.store')->middleware('permission:categories.create');
        Route::get('{id}', 'Admin\CategoryController@show')->name('category.show')->middleware('permission:categories.show');
        Route::patch('{id}', 'Admin\CategoryController@update')->name('category.update')->middleware('permission:categories.edit');
        Route::delete('{id}', 'Admin\CategoryController@delete')->name('category.delete')->middleware('permission:categories.delete');
    });

    Route::prefix('clients')->group(function() {
        Route::get('{type}', 'Admin\ClientsController@index')->where('type', 'buyer|seller')->name('clients.index')->middleware('permission:clients.show');
        Route::post('store', 'Admin\ClientsController@store')->name('clients.store')->middleware('permission:clients.create');
        Route::get('{id}', 'Admin\ClientsController@show')->name('clients.show')->middleware('permission:clients.view');
        Route::patch('{id}', 'Admin\ClientsController@update')->name('clients.update')->middleware('permission:clients.edit');
        Route::delete('{id}', 'Admin\ClientsController@delete')->name('clients.delete')->middleware('permission:clients.delete');
        Route::post('moderate/{id}', 'Admin\ClientsController@moderate')->name('clients.moderate')->middleware('permission:clients.edit');

        Route::post('/update/balance', 'Admin\ClientsController@updateBalance')->name('users.delete')->middleware('permission:users.delete');

//        добавлены роуты
        Route::post('store/user', 'Admin\ClientsController@storeUserClient')->name('clients.store.user')->middleware('permission:clients.create');
        Route::get('get/user', 'Admin\ClientsController@getAllClients')->name('clients.store.user')->middleware('permission:clients.view');
        Route::get('edit/user/{id}', 'Admin\ClientsController@getClient')->name('clients.store.user')->middleware('permission:clients.view');
        Route::post('update/user/{id}', 'Admin\ClientsController@updateUserClient')->name('clients.store.user')->middleware('permission:clients.edit');
        Route::post('banned/user/{id}', 'Admin\ClientsController@bannedClientUser')->name('clients.store.user')->middleware('permission:clients.edit');

        Route::post('score/create', 'Admin\ClientsController@generateScore')->name('clients.score.create')->middleware('permission:clients.edit');

        Route::post('generate/user/password', 'Admin\ClientsController@generatePassword')->name('clients.password.generate')->middleware('permission:clients.edit');
        Route::post('score/send', 'Admin\ClientsController@scoreSend')->name('clients.score.send')->middleware('permission:clients.edit');
//--------------------

        Route::delete('office/{id}', 'Admin\ClientsController@deleteOffice')->name('clients.office.delete')->middleware('permission:clients.edit');
        Route::delete('store/{id}', 'Admin\ClientsController@deleteStore')->name('clients.store.delete')->middleware('permission:clients.edit');
    });

    Route::prefix('users')->group(function() {
        Route::get('clients', 'Admin\UsersController@clients')->name('users')->middleware('permission:users.show');

        Route::get('', 'Admin\UsersController@index')->name('users')->middleware('permission:users.show');
        Route::post('store', 'Admin\UsersController@store')->name('users.store')->middleware('permission:users.create');
        Route::get('{id}', 'Admin\UsersController@show')->name('users.show')->middleware('permission:users.show');
        Route::patch('{id}', 'Admin\UsersController@update')->name('users.update')->middleware('permission:users.edit');
        Route::delete('{id}', 'Admin\UsersController@delete')->name('users.delete')->middleware('permission:users.delete');






        Route::post('/create/ticket/{id}', 'Admin\UsersController@sendMantisTicket')->name('users.ticket.create')->middleware('permission:users.delete');


    });

    Route::get('stock', 'Admin\NewsController@stock')->name('news.stock.index')->middleware('permission:publications.show');
    Route::get('news', 'Admin\NewsController@news')->name('news.index')->middleware('permission:publications.show');

    Route::prefix('news')->group(function() {
        Route::post('store', 'Admin\NewsController@store')->name('news.create')->middleware('permission:publications.create');
        Route::get('{id}', 'Admin\NewsController@show')->name('news.show')->middleware('permission:publications.show');
        Route::patch('{id}', 'Admin\NewsController@update')->name('news.update')->middleware('permission:publications.edit');
        Route::delete('{id}', 'Admin\NewsController@delete')->name('news.delete')->middleware('permission:publications.delete');
        Route::post('moderate/{id}', 'Admin\NewsController@moderate')->name('news.moderate')->middleware('permission:publications.moderate');
    });

    Route::prefix('feedback')->group(function() {
        Route::get('reports', 'Admin\FeedbackController@reports')->name('feedback.reports')->middleware('permission:feedback.show');
        Route::get('messages', 'Admin\FeedbackController@messages')->name('feedback.messages')->middleware('permission:feedback.show');
        Route::get('count', 'Admin\FeedbackController@feedcount')->name('feedback.count')->middleware('permission:feedback.show');
        Route::get('{id}', 'Admin\FeedbackController@show')->name('feedback.view')->middleware('permission:feedback.show');
        Route::delete('{id}', 'Admin\FeedbackController@delete')->name('feedback.delete')->middleware('permission:feedback.delete');
        Route::patch('{id}', 'Admin\FeedbackController@update')->name('feedback.update')->middleware('permission:feedback.edit');
    });

    Route::prefix('ad')->group(function() {
        Route::get('services', 'Admin\AdServiceController@services')->name('ad.services')->middleware('permission:adservice.show');
        Route::post('services/store', 'Admin\AdServiceController@store')->name('ad.services.store')->middleware('permission:adservice.show');
        Route::patch('service/{service}', 'Admin\AdServiceController@update')->name('ad.services.update')->middleware('permission:adservice.edit');
    });

    Route::prefix('deals')->group(function() {
        Route::get('', 'Admin\DealsController@index')->name('deals')->middleware('permission:publications.show');
        //        модерация
        Route::get('/show/moderate', 'Admin\DealsController@moderateIndex')->name('dealsModerate')->middleware('permission:publications.show');

        Route::get('{id}', 'Admin\DealsController@show')->name('deals.show')->middleware('permission:publications.show');
        Route::patch('{id}', 'Admin\DealsController@update')->name('deals.update')->middleware('permission:publications.show');
        Route::patch('moderation/success/{id}', 'Admin\DealsController@moderateSuccess')->name('deals.moderate.success')->middleware('permission:publications.show');
        Route::patch('moderation/fails/{id}', 'Admin\DealsController@moderateFails')->name('deals.moderate.fails')->middleware('permission:publications.show');
        Route::get('refund/moderation/{id}', 'Admin\DealsController@refundDealModerate')->name('deals.moderate.refund')->middleware('permission:publications.show');
        Route::delete('{id}', 'Admin\DealsController@delete')->name('deals.delete')->middleware('permission:publications.delete');

        Route::post('manager/store', 'Admin\DealsController@storeDealManager')->name('deals.manager.store')->middleware('permission:publications.delete');

        Route::post('upload/image', 'Admin\DealsController@uploadImageDeal')->name('deals.upload.image')->middleware('permission:publications.delete');
        Route::post('image/delete', 'Admin\DealsController@deleteImage')->name('deals.delete.image')->middleware('permission:publications.delete');

    });
});