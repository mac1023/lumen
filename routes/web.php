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


//$router->get('foo', ['as' => 'foo',function () {
//    return 'Hello World';
//}]);


//$router->post('foo', function () {
//    return 'i am post';
//});

//$router->get('user/{id}', function ($id) {
//    return 'User '.$id;
//});
//$router->get('user/{id}/show', ['as' => 'show', 'uses'=>'UsersController@show']);

//$router->get('profile', [
//    'as' => 'profile', 'uses' => 'UsersController@showProfile'
//]);



$api = app('Dingo\Api\Routing\Router');

$api->version('v2', function($api) {
    $api->get('version', function() {
        return response('this is version v2');
    });
});


$api->version('v1', ['namespace'=>'App\Http\Controllers'],function($api) {

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => 1000,
        'expires' => 1,
    ], function($api) {
        $api->get('version', function() {
            return response('this is version v1');
        });

        $api->get('users', ['as' => 'users.index', 'uses' => 'UsersController@index']);
        $api->get('users/{id}', ['as' => 'users.show', 'uses' => 'UsersController@show']);

        //短信
        $api->post('verificationCodes', ['as' => 'api.verificationCodes.store', 'uses' => 'VerificationCodesController@store']);

        // 用户注册
        $api->post('users', ['as'=>'api.users.store', 'uses'=>'UsersController@store']);


        // 图片验证码
        $api->post('captchas', ['as'=>'api.captchas.store', 'uses'=>'CaptchasController@store']);
    });




});




