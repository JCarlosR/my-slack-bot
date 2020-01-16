<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logs', 'LogController@index');
Route::get('/events', 'SlackEventController@index');

Route::get('/send/message', 'SlackMessageController@newMessage');
Route::post('/send/message', 'SlackMessageController@sendMessage');

Route::get('/send/command', 'SlackMessageController@newCommand');
Route::post('/send/command', 'SlackMessageController@sendCommand');