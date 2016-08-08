<?php

namespace App\Http\Controllers;

use App\SmtpListForCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function goodSmtp(Request $request){

        $smtpList = SmtpListForCheck::where(['isget'=>1, 'status'=>'SENT'])->get();
        $filename = "download_good_".time('U').".txt";
        $arr=[];

        $max = count($smtpList);
        $countNow = 0;

        foreach ($smtpList as $smtp){
            $arr[] = $smtp->smtp;
            $countNow++;
            if(count($arr)>100 || $countNow == $max){
                Storage::disk('local')->put('download/'.$filename, implode("\n",$arr));
                $arr = [];
            }
        }

        return Response::download(storage_path('app/download/').'\\'.$filename, $filename);
    }

    public function badSmtp(Request $request){

        $smtpList = SmtpListForCheck::where(['isget'=>1, 'status'=>'BAD'])->get();
        $filename = "download_bad_".time('U').".txt";
        $arr=[];

        $max = count($smtpList);
        $countNow = 0;

        foreach ($smtpList as $smtp){
            $arr[] = $smtp->smtp." ошибка: ".$smtp->errmsg;
            $countNow++;
            if(count($arr)>100 || $countNow == $max){
                Storage::disk('local')->put('download/'.$filename, implode("\n",$arr));
                $arr = [];
            }
        }

        return Response::download(storage_path('app/download/').'\\'.$filename, $filename);
    }

    public function goMails(Request $request, $filename){
        return Response::download(storage_path('app/'.config('config.emails.go_mails'))."/".$filename, $filename);
    }

    public function fromname(Request $request, $filename){
        return Response::download(storage_path('app/'.config('config.fromname'))."/".$filename, $filename);
    }

    public function attach(Request $request, $filename){
        return Response::download(storage_path('app/'.config('config.go_attach'))."/".$filename, $filename);
    }

    public function checkAttach($filename){
        return Response::download(storage_path('app/'.config('config.smtp_check_attach'))."/".$filename, $filename);
    }

    public function mailTextFile($filename){
        return Response::download(storage_path('app/'.config('config.mailTextFile'))."/".$filename, $filename);
    }


}
