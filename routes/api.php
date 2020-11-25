<?php


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['namespace' => 'Api', 'prefix' => 'api'], function() use ($router) {

	$router->group(['namespace' => 'V1', 'prefix' => 'v1'], function() use ($router) {

        $router->group(['namespace' => 'User'], function() use ($router) {

        	$router->get('/user', 'UserController@show'); //获取用户
            $router->post('/user', 'UserController@store'); //注册用户
            $router->put('/user', 'UserController@update'); //编辑用户
            $router->delete('/user', 'UserController@destroy'); //删除用户
	    });

    });
    
});