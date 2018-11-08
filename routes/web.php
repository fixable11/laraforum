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

Route::get('/test',function(){
    phpinfo();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('threads', 'ThreadsController@index')->name('threads');
Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::put('/threads/{channel}/{thread}', 'ThreadsController@update')->name('threads.update');
Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');


Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');
Route::post('/threads', 'ThreadsController@store')->middleware('must-be-confirmed');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy');

Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

Route::post('/threads/{thread}/replies', 'RepliesController@store')->name('add_reply_to_t');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');
Route::put('/replies/{reply}', 'RepliesController@update');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

Route::get('/register/confirm', 'Api\RegisterConfirmationController@index')->name('register.confirm');

Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->name('avatar');