<?php

namespace App\Http\Controllers;

use App\MailSettings;
use App\SettingsForCheckSMTP;
use App\ControlMailList;
use App\SmtpListForCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use narutimateum\Toastr\Facades\Toastr;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function smtpSettings()
    {

        $settings = SettingsForCheckSMTP::whereId(1)->first()->toArray();

        return view('settings.smtp.index', compact('settings'));
    }

    public function emailSettings()
    {
        $settings = MailSettings::whereId(1)->first()->toArray();

        return view('settings.emails.index', compact('settings'));
    }

    public function smtpSettingsStore(Request $request)
    {
        $settings = SettingsForCheckSMTP::whereId(1)->first();
        $settings->fill($request->all());
        $request->get('mailText') ? $settings->mailText = 1 : $settings->mailText = 0;
        $request->get('includefile') ? $settings->includefile = 1 : $settings->includefile = 0;
        $settings->save();
        Toastr::success("Изменения сохранены");

        return redirect('/settings/smtp');
    }

    public function emailSettingsStore(Request $request)
    {
        $settings = MailSettings::whereId(1)->first();
        $settings->fill($request->all());
        $request->get('html') ? $settings->html = 1 : $settings->html = 0;
        $settings->save();
        Toastr::success("Изменения сохранены");

        return redirect('/settings/email');
    }

    public function storeMailTextFile(Request $request)
    {
        $file = $request->file('file');
        Storage::disk('local')->put(config('config.mailTextFile') . '/' . $file->getClientOriginalName(),
            File::get($file));
        Toastr::success("Файл " . $file->getClientOriginalName() . ' загружен');

        return redirect('/settings/smtp');
    }

    public function storeSmtpList(Request $request)
    {
        $file  = $request->file('file');
        $count = 0;
        DB::table('smtplistforcheck')->truncate();
        foreach (explode("\n",File::get($file)) as $item) {
            $array[] = ['smtp' => $item];
            if (count($array) > 100) {
                SmtpListForCheck::insert($array);
                $array = [];
            }
            $count++;
        }
        Toastr::success("Загружено SMTP:  ".$count);

        return redirect('/settings/smtp');
    }

    public function storeMailList(Request $request)
    {
        $file  = $request->file('file');
        $count = 0;
        DB::table('controlmaillist')->truncate();
        foreach (explode("\n",File::get($file)) as $item) {
            $array[] = ['mail' => $item];
            if (count($array) > 100) {
                ControlMailList::insert($array);
                $array = [];
            }
            $count++;
        }
        Toastr::success("Загружено Control Mail:  ".$count);

        return redirect('/settings/smtp');
    }

}
