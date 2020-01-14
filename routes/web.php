<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logs', 'LogController@index');

Route::get('/send', 'SlackMessageController@newMessage');
Route::post('/send', 'SlackMessageController@sendMessage');