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

$router->group(['prefix' => 'api/v1/'], function() use($router){
    // main flow route API
    // user resource API 'UserController@getUsers'
    $router->group(['prefix' => 'users'], function() use($router){
        $router->get('/', ['as' => 'getUsers', 'uses' => 'UserController@getUsers']); //GET all User
        $router->get('/{id}', ['as' => 'getUser', 'uses' => 'UserController@getUser']); // GET spesific user
        $router->get('/{id}/profile', ['as' => 'getUserProfile', 'uses' => 'UserController@getUserProfile']);
        $router->get('/{id}/posts', ['as' => 'getUserPosts', 'uses' => 'UserController@getUserPosts']);
        $router->post('/', ['as' => 'createUser', 'uses' => 'UserController@createUser']); //POST new user
        $router->post('/auth', ['as' => 'auth', 'uses' => 'UserController@auth']);

        // authed user api
        // $router->group(['middleware' => 'auth'], function() use($router){
            // $router->put('/{id}', UserController@replaceUser); //REPLACE user
            //$router->patch('/{id}', 'UserController@updateUser'); //UPDATE part of user
            // $router->delete('/{id}', UserController@deleteUser); //DELETE user

        // });
    });
    $router->group(['prefix' => 'posts'], function() use ($router){
        $router->get('/', ['as' => 'getPosts', 'uses' => 'PostController@getPosts']);
        $router->get('/{id}', ['as' => 'getPost', 'uses' => 'PostController@getPost']);
        $router->get('/{id}/comments', ['as' => 'getPostComments', 'uses' => 'PostController@getPostComments']);
        $router->get('/{id}/likes', ['as' => 'getPostLikes', 'uses' => 'PostController@getPostLikes']);
    });
});

// for SPA web redirection
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/encrypt/{value}', function ($value) use ($router) {
    return \Illuminate\Support\Facades\Crypt::encrypt($value);
});