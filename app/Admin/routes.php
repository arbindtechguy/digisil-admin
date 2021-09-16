<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->post('/register_category', 'CategoryRanking@addCategory')->name('addCategory');
    $router->get('/app_group/{categoryID}', 'GroupRanking@groupList')->name('groupList');
    $router->post('/app_group/{categoryID}', 'GroupRanking@addGroup')->name('addGroup');
    $router->get('/appsList/{categoryID}', 'AppRanking@appsList')->name('appsList');
    $router->post('/add_app/{groupId}', 'AppRanking@addApp')->name('addApp');

    $router->get('/delete_app/{id}', 'AppRanking@deleteApp')->name('deleteApp');
    $router->get('/delete_category/{id}', 'CategoryRanking@deleteCategory')->name('deleteCategory');

});
