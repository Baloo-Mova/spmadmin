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

        $mails = scandir(storage_path('app') . '/' . config('config.emails.mails'));
        $attach = scandir(storage_path('app') . '/' . config('config.attach'));
        $go_mails = scandir(storage_path('app') . '/' . config('config.emails.go_mails'));

        $data = [
            'smtpCount'         => SMTP::count(),
            'mailsFileCount'    => count($mails)-2,// count(Storage::files(config('config.emails.mails'))),
            'attachFileCount'   => count($attach)-2,//count(Storage::files(config('config.attach'))),
            'go_mailsFileCount' => count($go_mails)-2,//count(Storage::files(config('config.emails.go_mails'))),
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
        $emailInfo['good'] = smtpfind::where('status','like','smtp%')->count();
        $emailInfo['bad'] = smtpfind::where('status','like','none%')->count();

        $Epool              = [];
        $Epool['needCheck'] = smtpfindpiece::where(['isget' => 0])->count();
        $Epool['inCheck'] = smtpfindpiece::where(['isget'=>1])->count(); 
        $Epool['good'] = smtpfindpiece::where('status','like','smtp%')->count();
        $Epool['bad'] = smtpfindpiece::where('status','like','none%')->count();

        return view('home.index',
            compact('data', 'status', 'bots', 'checkBlackList', 'botsInfo', 'smtpInfo', 'pool','emailInfo','Epool'));
    }

    public function delete($name)
    {
        switch ($name) {
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

    public function uploadEmailsForSmtpFind(){
        if (Storage::has(config('config.smtpfind'))) {
            $emails = explode("\n", Storage::get(config('config.smtpfind')));
            $now    = 1;
            DB::table('smtpfind')->truncate();
            $smtps = [];
            $rules = explode("\n",Storage::get(config('config.smtp_find_default_domains')));
            foreach ($rules as $rule){
                $tmp = explode('|', $rule);
                $smtps[] = [
                    "smtp"=>trim($tmp[0]),
                    "domain"=>trim($tmp[1]),
                ];
            }

            foreach ($emails as $email) {
                $status = "";
                $temp = explode(':',$email);
                $domain = explode('@',$temp[0]);
                $isget = 0;
                foreach ($smtps as $smtp){
                    if(trim($domain[1]) == $smtp['smtp']){
                        //smtp://john@gmail.com|smtp.gmail.com:465|john@gmail.com|passw
                        $status = "smtp://".$temp[0]."|".$smtp['domain']."|".$email;
                        $isget = 1;
                    }
                }

                $array[] = ['emailpas' => trim($email), 'status'=>$status, 'isget'=>$isget];
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
