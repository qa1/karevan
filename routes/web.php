<?php

use Illuminate\Support\Facades\Route;

//
// ─── MISCELLANEOUS ──────────────────────────────────────────────────────────────
//

Route::get('/', 'HomeController@index')->name('dashboard');

//
// ─── AUTHENTICATION ─────────────────────────────────────────────────────────────
//

Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::get('login/asadmin', 'LoginController@loginAsAdmin')->name('loginAsAdmin');
    Route::post('login', 'LoginController@login');

    Route::post('logout', 'LoginController@logout')->name('logout');
});

//
// ─── LOGIN REQUIRED ─────────────────────────────────────────────────────────────
//

Route::middleware('auth')->group(function () {
    // Persons
    Route::group(['prefix' => 'persons', 'namespace' => 'Persons'], function () {
        Route::get('/', 'ManageController@index')->name('persons.index');
        Route::get('/data', 'ManageController@datatable')->name('persons.index.datatable');
        Route::get('/info', 'ManageController@personInfo')->name('persons.info');
        Route::get('/{person}/delete', 'ManageController@remove')->name('persons.delete');
        Route::get('/{person}/edit', 'EditController@index')->name('persons.edit');
        Route::post('/{person}/edit', 'EditController@postIndex');
        Route::get('/{person}/deleteimage', 'EditController@deleteImage')->name('persons.deleteimage');
        Route::get('/{person}/message', 'MessageController@index')->name('persons.message');
        Route::post('/{person}/message', 'MessageController@postIndex');
        Route::get('/{person}/clearban', 'ManageController@clearban')->name('persons.clearban');

        Route::get('/register', 'RegisterController@index')->name('person.register');
        Route::post('/register', 'RegisterController@postIndex');
    });

    // Export
    Route::group(['prefix' => 'export', 'namespace' => 'Export'], function () {
        Route::any('/person', 'PersonController@index')->name('export.person');
    });

    // Messages
    Route::group(['prefix' => 'messages', 'namespace' => 'Messages'], function () {
        Route::get('/', 'ManageController@index')->name('messages.index');
        Route::get('/data', 'ManageController@anyData')->name('messages.index.data');
        Route::get('/info', 'ManageController@messageInfo')->name('messages.info');
        Route::get('/{id}/delete', 'ManageController@remove')->name('messages.delete');
        Route::post('/{id}/readed', 'ManageController@readed')->name('messages.readed');
        Route::get('/{id}/readed', 'ManageController@readed');
        Route::get('/{id}/unread', 'ManageController@unread')->name('messages.unread');
        Route::get('/{message}/edit', 'EditController@index')->name('messages.edit');
        Route::post('/{message}/edit', 'EditController@postIndex');
    });

    // Importer
    Route::group(['prefix' => 'importer', 'namespace' => 'Importer'], function () {
        Route::get('/', 'ManageController@index')->name('importer');
        Route::post('/barresi', 'BarresiController@index')->name('importer.barresi');
        Route::post('/import', 'ImportController@index')->name('importer.import');
    });

    // Cities
    Route::group(['prefix' => 'cities', 'namespace' => 'Cities'], function () {
        Route::get('/', 'ManageController@index')->name('cities.index');
        Route::get('/data', 'ManageController@anyData')->name('cities.index.data');
        Route::get('/{city}/delete', 'ManageController@remove')->name('cities.delete');
        Route::get('/create', 'ManageController@create')->name('cities.create');
        Route::post('/create', 'ManageController@postCreate')->name('cities.create');
        Route::get('/{city}/edit', 'EditController@index')->name('cities.edit');
        Route::post('/{city}/edit', 'EditController@postIndex');
    });

    // Modir Karevans
    Route::group(['prefix' => 'modirkarevans', 'namespace' => 'ModirKarevans'], function () {
        Route::get('/', 'ManageController@index')->name('modirkarevans.index');
        Route::get('/data', 'ManageController@anyData')->name('modirkarevans.index.data');
        Route::get('/{modir}/delete', 'ManageController@remove')->name('modirkarevans.delete');
        Route::get('/create', 'ManageController@create')->name('modirkarevans.create');
        Route::post('/create', 'ManageController@postCreate');
        Route::get('/{modirkarevan}/edit', 'ManageController@edit')->name('modirkarevans.edit');
        Route::post('/{modirkarevan}/edit', 'ManageController@postEdit');
    });

    // Taradod
    Route::group(['prefix' => 'taradod'], function () {
        Route::get('/', 'TaradodController@index')->name('taradod.index');
        Route::post('/', 'TaradodController@postIndex')->name('taradod.index');
    });

    // Status
    Route::group(['prefix' => 'status', 'namespace' => 'Persons'], function () {
        Route::get('/', 'StatusController@index')->name('status.index');
        Route::post('/', 'StatusController@postIndex');
    });

    // Screenshot
    Route::group(['prefix' => 'screenshot'], function () {
        Route::get('/', 'ScreenshotController@index')->name('screenshot.index');
        Route::post('/', 'ScreenshotController@postIndex')->name('screenshot.index');
    });

    // Report
    Route::group(['prefix' => 'report', 'namespace' => 'Report'], function () {
        Route::get('error', 'ErrorController@index')->name('report.error.index');
        Route::get('error/data', 'ErrorController@data')->name('report.error.data');

        Route::get('karevan', 'KarevanController@index')->name('report.karevan.index');

        Route::get('taradod', 'TaradodController@index')->name('report.taradod.index');
    });

    // Users
    Route::group(['prefix' => 'users', 'namespace' => 'Users'], function () {
        Route::get('/', 'ManageController@index')->name('users.index');
        Route::get('data', 'ManageController@anyData')->name('users.index.data');
        Route::get('{user}/delete', 'ManageController@remove')->name('users.delete');
        Route::get('create', 'CreateController@index')->name('users.create');
        Route::post('create', 'CreateController@postIndex');
        Route::get('{user}/edit', 'EditController@index')->name('users.edit');
        Route::post('{user}/edit', 'EditController@postIndex');
    });

    // Person To Code
    Route::group(['prefix' => 'persontocode', 'namespace' => 'PersonToCode'], function () {
        Route::get('/', 'ManageController@index')->name('persontocode');
        Route::post('/', 'ManageController@postIndex')->name('persontocode');
        Route::post('/setcode', 'SetController@index')->name('persontocode.setcode');
    });

    // Ban Karevan
    Route::group(['prefix' => 'bankarevan', 'namespace' => 'BanKarevan'], function () {
        Route::get('/', 'ManageController@index')->name('bankarevan');
        Route::post('/', 'ManageController@postIndex')->name('bankarevan');
    });

    // Access Control
    Route::group(['prefix' => 'rbac', 'namespace' => 'Rbac'], function () {
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', 'RolesController@index')->name('rbac.roles');
            Route::get('/datatable', 'RolesController@datatable')->name('rbac.roles.datatable');
            Route::get('/create', 'RolesController@create')->name('rbac.roles.create');
            Route::post('/create', 'RolesController@postCreate');
            Route::get('/{role}/edit', 'RolesController@edit')->name('rbac.roles.edit');
            Route::post('/{role}/edit', 'RolesController@postEdit');
            Route::get('/{role}/delete', 'RolesController@delete')->name('rbac.roles.delete');
        });

        Route::group(['prefix' => 'permissions'], function () {
            Route::get('/', 'PermissionsController@index')->name('rbac.permissions');
            Route::get('/datatable', 'PermissionsController@datatable')->name('rbac.permissions.datatable');
            Route::get('/create', 'PermissionsController@create')->name('rbac.permissions.create');
            Route::post('/create', 'PermissionsController@postCreate');
            Route::get('/{permission}/edit', 'PermissionsController@edit')->name('rbac.permissions.edit');
            Route::post('/{permission}/edit', 'PermissionsController@postEdit');
            Route::get('/{permission}/delete', 'PermissionsController@delete')->name('rbac.permissions.delete');
        });
    });
});
