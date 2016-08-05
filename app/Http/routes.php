<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@logout');

Route::get('/cmd', 'CommandController@index');
Route::get('/test', 'HomeController@test');
Route::get('/delete/{name}', 'HomeController@delete');
Route::get('/smtp-upload', 'HomeController@uploadSmtp');

Route::get('/email-settings', 'SettingsController@emailSettings');
Route::get('/smtp-settings', 'SettingsController@smtpSettings');
Route::post('/email-settings', 'SettingsController@emailSettingsStore');
Route::post('/smtp-settings', 'SettingsController@smtpSettingsStore');