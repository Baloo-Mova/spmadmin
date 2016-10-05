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

Route::get('/', ['uses'=>'HomeController@index', 'as'=>'home']);

Route::get('/'.config('config.login'), ['uses'=>'Auth\AuthController@getLogin', 'as'=>'login']);
Route::post('/'.config('config.login'), ['uses'=>'Auth\AuthController@postLogin', 'as'=>'login.post']);
Route::get('/logout', ['uses'=>'Auth\AuthController@logout', 'as'=>'logout']);

Route::get('/cmd', ['uses'=>'CommandController@index', 'as'=>'cmd']);
Route::post('/cmd', ['uses'=>'CommandController@postIndex', 'as'=>'cmd.post']);
Route::post('/sendcheckres', ['uses'=>'CommandController@sendcheckers', 'as'=>'sendcheckres']);
Route::post('/smtpcheckres', ['uses'=>'CommandController@smtpcheckres', 'as'=>'smtpcheckres']);


Route::get('/delete/{name}', ['uses'=>'HomeController@delete', 'as'=>'delete']);
Route::get('/smtp-upload', ['uses'=>'HomeController@uploadSmtp', 'as'=>'smtp.upload']);
Route::get('/smtpfindupload', ['uses'=>'HomeController@uploadEmailsForSmtpFind', 'as'=>'smtpfindupload']);

Route::get('/settings/email', ['uses'=>'SettingsController@emailSettings', 'as'=>'email.settings']);
Route::get('/settings/smtp', ['uses'=>'SettingsController@smtpSettings', 'as'=>'smtp.settings']);
Route::post('/settings/email', ['uses'=>'SettingsController@emailSettingsStore', 'as'=>'email.setting.post']);
Route::post('/settings/smtp', ['uses'=>'SettingsController@smtpSettingsStore', 'as'=>'smtp.settings.post']);
Route::get('/settings/find',['uses'=>"SettingsController@findSettings", 'as'=>'settings.find']);
Route::post('/settings/find',['uses'=>"SettingsController@findSettingsStore", 'as'=>'settings.find.post']);

Route::post('/settings/mail-text-file', ['uses'=>'SettingsController@storeMailTextFile', 'as'=>'textfile.settings']);
Route::post('/settings/smtp-list', ['uses'=>'SettingsController@storeSmtpList', 'as'=>'smtplist.settings']);
Route::post('/settings/mail-list', ['uses'=>'SettingsController@storeMailList', 'as'=>'maillist.settings']);

Route::get('/status/{statusName}', ['uses'=>'StatusController@changeStatus', 'as'=>'status']);
Route::get('/blackList/{status}' , ['uses'=>'StatusController@changeBlack', 'as'=>'blacklist.status']);

Route::get('/download/goodSmtp', ['uses'=>'DownloadController@goodSmtp', 'as'=>'goodsmtp.download']);
Route::get('/download/badSmtp', ['uses'=>'DownloadController@badSmtp', 'as'=>'badsmtp.download']);
Route::get('/download/goodEmail', ['uses'=>'DownloadController@goodEmail', 'as'=>'goodemail.download']);
Route::get('/download/badEmail', ['uses'=>'DownloadController@badEmail', 'as'=>'bademail.download']);
Route::get('/download/go-mails/{filename}', ['uses'=>'DownloadController@goMails', 'as'=>'gomails.download']);
Route::get('/download/fromname/{filename}', ['uses'=>'DownloadController@fromname', 'as'=>'fromname.download']);
Route::get('/download/attach/{filename}', ['uses'=>'DownloadController@attach', 'as'=>'attach.download']);
Route::get('/download/smtp_check_attach/{filename}', ['uses'=>'DownloadController@checkAttach', 'as'=>'smtpcheckattach.download']);
Route::get('/download/mailTextFile/{filename}', ['uses'=>'DownloadController@mailTextFile', 'as'=>'mailtextfile.download']);

Route::get('/download/{filename}', function($filename){
    return Response::download(storage_path('app/download/') . $filename, $filename);
});

Route::get('/update-smtp-pull', ['uses'=>'PullController@smtp', 'as'=>'update.smtp.pool']);
Route::get('/update-email-pull', ['uses'=>'PullController@email', 'as'=>'update.email.pool']);

Route::group(['prefix'=>'web-work'], function (){
    Route::get('/spam-attach-index', ['uses'=>'WebWorkSetController@spamAttachIndex','as'=>'webwork.spam.attach.index']);
});


