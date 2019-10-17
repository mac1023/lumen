<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('foo', ['as' => 'foo',function () {
    return 'Hello World';
}]);


$router->post('foo', function () {
    return 'i am post';
});

$router->get('user/{id}', function ($id) {
    return 'User '.$id;
});

//$router->get('profile', ['as' => 'profile', function () {
//    return 'i am rename';
//}]);

$router->get('profile', [
    'as' => 'profile', 'uses' => 'UsersController@showProfile'
]);


$router->get('user/{id}/show', ['as' => 'show', 'uses'=>'UsersController@show']);



//$router->get('users', [
//    'as' => 'users', 'uses' => 'UsersController@show'
//]);

//$router->get('users.show','Uer');


//$api = app('Dingo\Api\Routing\Router');
//
//$api->version('v1', function ($api) {
//    $api->get('users/{id}', 'App\Api\Controllers\UserController@show');
//});
