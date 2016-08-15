<?php

namespace App\Http\Controllers;

use App\smtpfind;
use App\SmtpListForCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function goodSmtp(Request $request)
    {

        $count    = SmtpListForCheck::where(['isget' => 1, 'status' => 'SENT'])->count();
        $filename = "download_good_" . time('U') . ".txt";
        $arr      = [];
        $countI   = ceil($count / 15000);
        for ($i = 0; $i < $countI + 1; $i++) {
            $smtpList = SmtpListForCheck::where(['isget'  => 1,
                                                 'status' => 'SENT'
            ])->take(15000)->skip($i * 15000)->get();
            foreach ($smtpList as $smtp) {
                $arr[] = $smtp->smtp . " ошибка: " . $smtp->errmsg;
            }
            Storage::disk('local')->append('download/' . $filename, implode("\n", $arr));
            $arr = [];
        }

        return Response::download(storage_path('app/download/') . $filename, $filename);
    }

    public function badSmtp(Request $request)
    {
        $count    = SmtpListForCheck::where(['isget' => 1, 'status' => 'BAD'])->count();
        $filename = "download_bad_" . time('U') . ".txt";
        $arr      = [];
        $countI   = ceil($count / 15000);
        for ($i = 0; $i < $countI + 1; $i++) {
            $smtpList = SmtpListForCheck::where(['isget'  => 1,
                                                 'status' => 'BAD'
            ])->take(15000)->skip($i * 15000)->get();
            foreach ($smtpList as $smtp) {
                $arr[] = $smtp->smtp . " ошибка: " . $smtp->errmsg;
            }
            Storage::disk('local')->append('download/' . $filename, implode("\n", $arr));
            $arr = [];
        }

        return Response::download(storage_path('app/download/') . $filename, $filename);
    }

    public function goodEmail(Request $request)
    {
        $count = smtpfind::where('status', 'like', 'smtp%')->count();

        $filename = "download_good_email_" . time('U') . ".txt";
        $arr      = [];
        $countI   = ceil($count / 15000);

        for ($i = 0; $i < $countI + 1; $i++) {
            $smtpList = smtpfind::where('status', 'like', 'smtp%')->take(15000)->skip($i * 15000)->get();
            foreach ($smtpList as $smtp) {
                $arr[] = $smtp->status;
            }
            Storage::disk('local')->append('download/' . $filename, implode("\n", $arr));
            $arr = [];
        }

        return Response::download(storage_path('app/download/') . $filename, $filename);
    }

    public function badEmail(Request $request)
    {
        $count = smtpfind::where('status', 'like', 'none%')->count();

        $filename = "download_bad_email_" . time('U') . ".txt";
        $arr      = [];
        $countI   = ceil($count / 15000);

        for ($i = 0; $i < $countI + 1; $i++) {
            $smtpList = smtpfind::where('status', 'like', 'none%')->take(15000)->skip($i * 15000)->get();
            foreach ($smtpList as $smtp) {
                $arr[] = $smtp->status;
            }
            Storage::disk('local')->append('download/' . $filename, implode("\n", $arr));
            $arr = [];
        }

        return Response::download(storage_path('app/download/') . $filename, $filename);
    }

    public function goMails(Request $request, $filename)
    {
        return Response::download(storage_path('app/' . config('config.emails.go_mails')) . "/" . $filename, $filename);
    }

    public function fromname(Request $request, $filename)
    {
        return Response::download(storage_path('app/' . config('config.fromname')) . "/" . $filename, $filename);
    }

    public function attach(Request $request, $filename)
    {
        return Response::download(storage_path('app/' . config('config.attach')) . "/" . $filename, $filename);
    }

    public function checkAttach($filename)
    {
        return Response::download(storage_path('app/' . config('config.smtp_check_attach')) . "/" . $filename,
            $filename);
    }

    public function mailTextFile($filename)
    {
        return Response::download(storage_path('app/' . config('config.mailTextFile')) . "/" . $filename, $filename);
    }

}
