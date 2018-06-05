<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{username}', function($username) {
	return View::make('chats')->with('username',$username);
});

Route::post('/sendMessage', array('uses' => 'ChatController@sendMessage'));

Route::post('/isTyping', array('uses' => 'ChatController@isTyping'));

Route::post('/notTyping', array('uses' => 'ChatController@notTyping'));

Route::post('/retrieveChatMessages', array('uses' => 'ChatController@retrieveChatMessages'));

Route::post('/retrieveTypingStatus', array('uses' => 'ChatController@retrieveTypingStatus'));