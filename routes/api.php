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


Route::group(['namespace' => 'Api'], function () {
    Route::post('/auth/register','AuthController@register');

    Route::post('/auth/login','AuthController@login');

    Route::get('/user', 'UserController@index');


    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('/snippets', 'SnippetController@index');
        Route::post('/snippets', 'SnippetController@store');
        Route::put('/snippets/{snippet}', 'SnippetController@update');
        Route::get('/snippets/{snippet}', 'SnippetController@show');

        Route::delete('/snippets/{snippet}', 'SnippetController@destroy');

        Route::get('/categories', 'CategoryController@index');

        Route::get('/tags', 'TagController@index');
        Route::post('/tags', 'TagController@store');
        Route::put('/tags/{tag}', 'TagController@update');
        Route::get('/tags/{tag}', 'TagController@show');
        Route::delete('/tags/{tag}', 'TagController@destroy');
    });
});


