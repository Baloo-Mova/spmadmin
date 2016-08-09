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
Route::post('/cmd', 'CommandController@postIndex');
Route::post('/sendcheckers', 'CommandController@sendcheckers');
Route::post('/smtpcheckres', 'CommandController@smtpcheckres');


Route::get('/delete/{name}', 'HomeController@delete');
Route::get('/smtp-upload', 'HomeController@uploadSmtp');
Route::get('/themes', 'HomeController@themes');
Route::get('/messages', 'HomeController@messages');
Route::get('/smtpfindupload', 'HomeController@uploadEmailsForSmtpFind');

Route::get('/settings/email', 'SettingsController@emailSettings');
Route::get('/settings/smtp', 'SettingsController@smtpSettings');
Route::post('/settings/email', 'SettingsController@emailSettingsStore');
Route::post('/settings/smtp', 'SettingsController@smtpSettingsStore');

Route::post('/settings/mail-text-file', 'SettingsController@storeMailTextFile');
Route::post('/settings/smtp-list', 'SettingsController@storeSmtpList');
Route::post('/settings/mail-list', 'SettingsController@storeMailList');

Route::get('/status/{statusName}', 'StatusController@changeStatus');
Route::get('/blackList/{status}' , 'StatusController@changeBlack');

Route::get('/download/goodSmtp', 'DownloadController@goodSmtp');
Route::get('/download/badSmtp', 'DownloadController@badSmtp');
Route::get('/download/goodEmail', 'DownloadController@goodEmail');
Route::get('/download/badEmail', 'DownloadController@badEmail');
Route::get('/download/go-mails/{filename}', 'DownloadController@goMails');
Route::get('/download/fromname/{filename}', 'DownloadController@fromname');
Route::get('/download/attach/{filename}', 'DownloadController@attach');
Route::get('/download/smtp_check_attach/{filename}', 'DownloadController@checkAttach');
Route::get('/download/mailTextFile/{filename}', 'DownloadController@mailTextFile');

Route::get('/update-smtp-pull', 'PullController@smtp');
Route::get('/update-email-pull', 'PullController@email');


